<?php
include('authentication.php');



// Delete Book
if(isset($_POST['delete_book']))
{
     $book_id = mysqli_real_escape_string($con, $_POST['delete_book']);

     $check_img_query = "SELECT * FROM book WHERE book_id ='$book_id'";
     $img_result = mysqli_query($con, $check_img_query);
     $result_data = mysqli_fetch_array($img_result);

     $book_image = $result_data['book_image'];

     $query = "DELETE FROM book WHERE book_id ='$book_id'";
     $query_run = mysqli_query($con, $query);

     if($query_run)
     {
          if(file_exists('../uploads/books_img/'.$book_image))
          {
               unlink("../uploads/books_img/".$book_image);
          }

          $_SESSION['message_success'] = 'Book deleted successfully';
          header("Location: books.php");
          exit(0);
     }
     else
     {
          $_SESSION['message_error'] = 'Book not deleted';
          header("Location: books.php");
          exit(0);
     }
}

// Update Book
if(isset($_POST['update_book']))
{
     $book_id =mysqli_real_escape_string($con, $_POST['book_id']);

     
     $title = mysqli_real_escape_string($con, $_POST['title']);
     $author = mysqli_real_escape_string($con, $_POST['author']);
     $copyright_date = mysqli_real_escape_string($con, $_POST['copyright_date']);
     $publisher = mysqli_real_escape_string($con, $_POST['publisher']);
     $isbn = mysqli_real_escape_string($con, $_POST['isbn']);
     $place_publication = mysqli_real_escape_string($con, $_POST['place_publication']);
     $call_number = mysqli_real_escape_string($con, $_POST['call_number']);
     $accession_number = mysqli_real_escape_string($con, $_POST['accession_number']);
     $copy = mysqli_real_escape_string($con, $_POST['copy']);
     $category = mysqli_real_escape_string($con, $_POST['category']);
     $gen = mysqli_real_escape_string($con, $_POST['barcode']);
     
     $old_book_filename = $_POST['old_book_image'];

     $book_image = $_FILES['book_image']['name'];

     $update_book_filename = "";

     if($book_image != NULL)
     {
           // Rename the Image
           $book_extension = pathinfo($book_image, PATHINFO_EXTENSION);
           $book_filename = time().'.'.$book_extension;

           $update_book_filename =  $book_filename;
     }
     else
     {
          $update_book_filename = $old_book_filename;
     }
     
     $query = "UPDATE book SET title='$title', author='$author', copyright_date='$copyright_date', publisher='$publisher', isbn='$isbn', place_publication='$place_publication', call_number='$call_number', accession_number='$accession_number', copy='$copy', category_id='$category', barcode='$gen', book_image='$update_book_filename' WHERE book_id = '$book_id'";
     $query_run = mysqli_query($con, $query);
     
     

     if($query_run)
     {
          if($book_image != NULL)
          {
               if(file_exists('../uploads/books_img/'.$old_book_filename))
               {
                    unlink("../uploads/books_img/".$old_book_filename);
               }
          }
          move_uploaded_file($_FILES['book_image']['tmp_name'], '../uploads/books_img/'.$book_filename);
          
          $_SESSION['message_success'] = 'Book Updated successfully';
          header("Location: books.php");
          exit(0);
     }
     else
     {
          $_SESSION['message_error'] = 'Book not Updated';
          header("Location: books.php");
          exit(0);
     }
     
}

// Add Book
// Add Book
if(isset($_POST['add_book'])) {
     $title = mysqli_real_escape_string($con, $_POST['title']);
     $author = mysqli_real_escape_string($con, $_POST['author']);
     $copyright_date = mysqli_real_escape_string($con, $_POST['copyright_date']);
     $publisher = mysqli_real_escape_string($con, $_POST['publisher']);
     $isbn = mysqli_real_escape_string($con, $_POST['isbn']);
     $place_publication = mysqli_real_escape_string($con, $_POST['place_publication']);
     $call_number = mysqli_real_escape_string($con, $_POST['call_number']);
     $copy = mysqli_real_escape_string($con, $_POST['copy']);
     $category = mysqli_real_escape_string($con, $_POST['category']);
     $book_image = $_FILES['book_image']['name'];
 
     if($book_image != "") {
         $book_extension = pathinfo($book_image, PATHINFO_EXTENSION);
         $book_filename = time().'.'. $book_extension;
 
         $pre = "MCC"; // Prefix for the barcode
         $suf = "LRC"; // Suffix for the barcode
 
         // Insert book for each accession number
         for ($i = 1; $i <= $copy; $i++) {
             $accession_number = mysqli_real_escape_string($con, $_POST['accession_number_' . $i]);
             
             // Generate barcode based on accession number
             $gen = $pre . $accession_number . $suf;
 
             $query = "INSERT INTO book (title, author, copyright_date, publisher, isbn, place_publication, call_number, accession_number, copy, category_id, barcode, book_image, date_added) VALUES ('$title', '$author', '$copyright_date', '$publisher', '$isbn', '$place_publication', '$call_number', '$accession_number', '$copy', '$category', '$gen', '$book_filename', NOW())";
             $query_run = mysqli_query($con, $query);
         }
 
         if($query_run) {
             mysqli_query($con,"insert into barcode (pre_barcode,mid_barcode,suf_barcode) values ('$pre', '$mid', '$suf') ");
             
             move_uploaded_file($_FILES['book_image']['tmp_name'], '../uploads/books_img/'.$book_filename);
             $_SESSION['message_success'] = 'Book Added successfully';
             header("Location: books.php");
             exit(0);
         } else {
             $_SESSION['message_error'] = 'Book not Added';
             header("Location: books.php");
             exit(0);
         }
     } else {
         $_SESSION['message_error'] = 'Please upload a book image';
         header("Location: books.php");
         exit(0);
     }
 }
 
?>