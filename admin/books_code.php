<?php
include('authentication.php');



// Delete Book
if (isset($_POST['delete_book'])) {
    $accession_number = mysqli_real_escape_string($con, $_POST['accession_number']);

    // First, select the title from the book table based on the accession number
    $select_query = "SELECT title FROM book WHERE accession_number = '$accession_number'";
    $select_query_run = mysqli_query($con, $select_query);

    if (mysqli_num_rows($select_query_run) > 0) {
        $row = mysqli_fetch_assoc($select_query_run);
        $title = $row['title'];

        // Now delete the book
        $delete_query = "DELETE FROM book WHERE accession_number = '$accession_number'";
        $delete_query_run = mysqli_query($con, $delete_query);

        if ($delete_query_run) {
            $_SESSION['status'] = "Book accession number '$accession_number' deleted successfully";
            $_SESSION['status_code'] = "success";
            header("Location: book_views.php?title=" . urlencode($title) . "&tab=copies");
            exit(0);
        } else {
            $_SESSION['status'] = "Failed to delete book accession number '$accession_number'";
            $_SESSION['status_code'] = "error";
            header("Location: book_views.php?title=" . urlencode($title) . "&tab=copies");
            exit(0);
        }
    } else {
        $_SESSION['status'] = "No book found with accession number '$accession_number'";
        $_SESSION['status_code'] = "warning";
        header("Location: book_views.php?tab=copies");
        exit(0);
    }
}


// Update Book
if (isset($_POST['update_book'])) {
    $book_title = mysqli_real_escape_string($con, $_POST['title']);
    $old_book_title = mysqli_real_escape_string($con, $_POST['old_title']); // Assuming you have an input field for old title

    $title = mysqli_real_escape_string($con, $_POST['title']);
    $author = mysqli_real_escape_string($con, $_POST['author']);
    $copyright_date = mysqli_real_escape_string($con, $_POST['copyright_date']);
    $publisher = mysqli_real_escape_string($con, $_POST['publisher']);
    $isbn = mysqli_real_escape_string($con, $_POST['isbn']);
    $place_publication = mysqli_real_escape_string($con, $_POST['place_publication']);
    $call_number = mysqli_real_escape_string($con, $_POST['call_number']);
    $category = mysqli_real_escape_string($con, $_POST['category']);

    $old_book_filename = $_POST['old_book_image'];

    $book_image = $_FILES['book_image']['name'];

    $update_book_filename = "";

    if ($book_image != NULL) {
        // Rename the Image
        $book_extension = pathinfo($book_image, PATHINFO_EXTENSION);
        $book_filename = time() . '.' . $book_extension;

        $update_book_filename = $book_filename;
    } else {
        $update_book_filename = $old_book_filename;
    }

    // Update query
    $query = "UPDATE book SET title='$title', author='$author', copyright_date='$copyright_date', 
              publisher='$publisher', isbn='$isbn', place_publication='$place_publication', 
              call_number='$call_number', category_id='$category', book_image='$update_book_filename' 
              WHERE title = '$old_book_title'"; // Update based on old title

    $query_run = mysqli_query($con, $query);

    if ($query_run) {
        // If image is updated, delete old image and upload new one
        if ($book_image != NULL) {
            if (file_exists('../uploads/books_img/' . $old_book_filename)) {
                unlink("../uploads/books_img/" . $old_book_filename);
            }
            move_uploaded_file($_FILES['book_image']['tmp_name'], '../uploads/books_img/' . $book_filename);
        }

        $_SESSION['status'] = 'Book Updated successfully';
        $_SESSION['status_code'] = "success";
        header("Location: books.php");
        exit(0);
    } else {
        $_SESSION['status'] = 'Book not Updated';
        $_SESSION['status_code'] = "error";
        header("Location: books.php");
        exit(0);
    }
}

// Update Book Accession Number
if (isset($_POST['update_accession_number'])) {
    $old_accession_number = mysqli_real_escape_string($con, $_POST['old_accession_number']);
    $new_accession_number = mysqli_real_escape_string($con, $_POST['accession_number']);
    $barcode = 'MCC-LRC' . $new_accession_number;
    $check_query = "SELECT * FROM book WHERE accession_number = '$new_accession_number'";
    $check_query_run = mysqli_query($con, $check_query);

    if (mysqli_num_rows($check_query_run) > 0) {
        $_SESSION['status'] = "The new Accession Number already exists. Please choose a different one.";
        $_SESSION['status_code'] = "warning";
        header("Location: book_views.php?title=" . urlencode($_POST['title']) . "&tab=copies");
        exit(0);
    } else {
        $query = "UPDATE book SET accession_number = '$new_accession_number', barcode = '$barcode' WHERE accession_number = '$old_accession_number'";
        $query_run = mysqli_query($con, $query);

        if ($query_run) {
            $_SESSION['status'] = "Accession Number updated successfully";
            $_SESSION['status_code'] = "success";
            header("Location: book_views.php?title=" . urlencode($_POST['title']) . "&tab=copies");
            exit(0);
        } else {
            $_SESSION['status'] = "Failed to update Accession Number";
            $_SESSION['status_code'] = "error";
            header("Location: book_views.php?title=" . urlencode($_POST['title']) . "&tab=copies");
            exit(0);
        }
    }
}

// Check accession number already exists
if (isset($_POST['accession_number_check'])) {
    $accession_number = mysqli_real_escape_string($con, $_POST['accession_number']);
    $query = "SELECT * FROM book WHERE accession_number = '$accession_number'";
    $query_run = mysqli_query($con, $query);
    
    if (mysqli_num_rows($query_run) > 0) {
        echo json_encode(['exists' => true]);
    } else {
        echo json_encode(['exists' => false]);
    }
    exit;
}


// Add Book
if (isset($_POST['add_book'])) {
    // Collect form data
    $title = $_POST['title'];
    $author = $_POST['author'];
    $isbn = $_POST['isbn'];
    $publisher = $_POST['publisher'];
    $copyright_date = $_POST['copyright_date'];
    $place_publication = $_POST['place_publication'];
    $call_number = $_POST['call_number'];
    $category_id = $_POST['lrc_location']; // Updated to category_id
    $existing_image = $_POST['existing_image'];
    $copy = intval($_POST['copy']); // Number of copies to add

    // Handle the uploaded image
    $book_image = '';
    if (isset($_FILES['book_image']) && $_FILES['book_image']['error'] === UPLOAD_ERR_OK) {
        $image_tmp_name = $_FILES['book_image']['tmp_name'];
        $image_name = $_FILES['book_image']['name'];
        $image_size = $_FILES['book_image']['size'];
        $image_error = $_FILES['book_image']['error'];
        $image_type = $_FILES['book_image']['type'];

        $image_ext = pathinfo($image_name, PATHINFO_EXTENSION);
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($image_ext, $allowed_ext)) {
            if ($image_error === 0) {
                if ($image_size < 5000000) { // Limit to 5MB
                    $new_image_name = uniqid('', true) . "." . $image_ext;
                    $image_upload_path = '../uploads/books_img/' . $new_image_name;
                    move_uploaded_file($image_tmp_name, $image_upload_path);
                    $book_image = $new_image_name;
                } else {
                    $_SESSION['status'] = "Your file is too large.";
                    $_SESSION['status_code'] = "warning";
                    header("Location: book_add.php");
                    exit(0);
                }
            } else {
                $_SESSION['status'] = "There was an error uploading your file.";
                $_SESSION['status_code'] = "error";
                header("Location: book_add.php");
                exit(0);
            }
        } else {
            echo "You cannot upload files of this type.";
            $_SESSION['status'] = "You cannot upload files of this type.";
            $_SESSION['status_code'] = "warning";
            header("Location: book_add.php");
            exit(0);
        }
    } else {
        // Use existing image if no new image is uploaded
        $book_image = $existing_image;
    }

    // Prepare the SQL query to check for existing accession numbers
    $check_query = "SELECT COUNT(*) FROM book WHERE accession_number = ?";
    $check_stmt = mysqli_prepare($con, $check_query);

    if ($check_stmt) {
        $pre = "MCC"; // Prefix for the barcode
        $suf = "LRC"; // Suffix for the barcode

        for ($i = 1; $i <= $copy; $i++) {
            $accession_number = $_POST['accession_number_' . $i];
            
            // Bind the accession number parameter and execute the statement
            mysqli_stmt_bind_param($check_stmt, "s", $accession_number);
            mysqli_stmt_execute($check_stmt);
            mysqli_stmt_bind_result($check_stmt, $count);
            mysqli_stmt_fetch($check_stmt);

            if ($count > 0) {
                $_SESSION['status'] = "Accession number " . $accession_number . " already exists.";
                $_SESSION['status_code'] = "error";
                header("Location: book_add.php");
                exit(0);
            }
        }

        mysqli_stmt_close($check_stmt);
    } else {
        $_SESSION['status'] = "Error preparing the statement: " . mysqli_error($con);
        $_SESSION['status_code'] = "error";
        header("Location: book_add.php");
        exit(0);
    }

    // Prepare the SQL query to insert new books
    $insert_query = "INSERT INTO book (title, author, isbn, publisher, copyright_date, place_publication, call_number, category_id, book_image, accession_number, barcode, date_added, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), 'Available')";
    $insert_stmt = mysqli_prepare($con, $insert_query);

    if ($insert_stmt) {
        for ($i = 1; $i <= $copy; $i++) {
            $accession_number = $_POST['accession_number_' . $i];
            $barcode = $pre . '-' . $suf . $accession_number;
            
            // Bind parameters and execute the statement
            mysqli_stmt_bind_param($insert_stmt, "sssssssssss", $title, $author, $isbn, $publisher, $copyright_date, $place_publication, $call_number, $category_id, $book_image, $accession_number, $barcode);
            mysqli_stmt_execute($insert_stmt);
        }

        mysqli_stmt_close($insert_stmt);

        $_SESSION['status'] = "Book(s) added successfully.";
        $_SESSION['status_code'] = "success";
        header("Location: books.php");
        exit(0);
    } else {
        $_SESSION['status'] = "Error preparing the statement: " . mysqli_error($con);
        $_SESSION['status_code'] = "error";
        header("Location: book_add.php");
        exit(0);
    }
}

?>