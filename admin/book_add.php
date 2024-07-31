<?php 
$page = substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'], "/") + 1);
include('authentication.php');
include('includes/header.php'); 
include('./includes/sidebar.php'); 
?>

<!-- Include SweetAlert CSS and JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.0/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.0/dist/sweetalert2.all.min.js"></script>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Add Book</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="books.php">Book Collection</a></li>
                <li class="breadcrumb-item active">Add Book</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-end"></div>
                    <div class="card-body">
                        <form id="addBookForm" action="books_code.php" method="POST" enctype="multipart/form-data" onsubmit="return checkDuplicateAccessionNumbers()">
                            <div class="row d-flex justify-content-center mt-5">
                                <div class="col-12 col-md-5">
                                    <div class="mb-2 input-group-sm">
                                        <label for="title">Title</label>
                                        <select id="title_select" class="form-control" onchange="populateBookDetails()">
                                            <option value="">Select a title</option>
                                            <?php
                                            $query = "SELECT * FROM book GROUP BY title";
                                            $query_run = mysqli_query($con, $query);
                                            if(mysqli_num_rows($query_run) > 0) {
                                                foreach($query_run as $book) {
                                                    echo '<option value="'.htmlspecialchars(json_encode($book), ENT_QUOTES, 'UTF-8').'">'.$book['title'].'</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                        <input type="text" name="title" id="title" class="form-control mt-2" placeholder="Or type a new title" required>
                                    </div>
                                </div>
                                <div class="col-12 col-md-5">
                                    <div class="mb-2 input-group-sm">
                                        <label for="author">Author</label>
                                        <input type="text" name="author" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row d-flex justify-content-center">
                                <div class="col-12 col-md-5">
                                    <div class="mb-2 input-group-sm">
                                        <label for="isbn">ISBN</label>
                                        <input type="text" name="isbn" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-12 col-md-5">
                                    <div class="mb-2 input-group-sm">
                                        <label for="publisher">Publisher</label>
                                        <input type="text" name="publisher" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row d-flex justify-content-center">
                                <div class="col-12 col-md-5">
                                    <div class="mb-2 input-group-sm">
                                        <label for="copyright_date">Copyright Date</label>
                                        <input type="text" id="copyright_date"
                                               name="copyright_date"
                                               class="form-control"
                                               required
                                               autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-12 col-md-5">
                                    <div class="mb-2 input-group-sm">
                                        <label for="place_publication">Place of Publication</label>
                                        <input type="text" name="place_publication" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row d-flex justify-content-center">
                                <input type="hidden" name="new_barcode" value="<?= $new_barcode ?>">
                                <div class="col-12 col-md-5">
                                    <div class="mb-2 input-group-sm">
                                        <label for="call_number">Call Number</label>
                                        <input type="text" name="call_number" id="book_call_number" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-12 col-md-5">
                                    <div class="mb-2 input-group-sm">
                                        <label for="copy">Copy</label>
                                        <input type="number" name="copy" id="copy" class="form-control" min="1" required onchange="generateAccessionFields()">
                                    </div>
                                </div>
                            </div>
                            <div class="row d-flex justify-content-center">
                                <div class="col-12 col-md-10">
                                    <div class="mb-2 input-group-sm">
                                        <label for="accession_numbers">Accession Numbers</label>
                                        <div id="accession_numbers_container"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row d-flex justify-content-center">
                                <div class="col-12 col-md-5">
                                    <div class="mb-2 input-group-sm">
                                        <label for="lrc_location">LRC Location</label>
                                        <?php
                                        $category = "SELECT * FROM category";
                                        $category_run = mysqli_query($con, $category);
                                        if(mysqli_num_rows($category_run) > 0) {
                                        ?>
                                        <select name="lrc_location" id="lrc_location" class="form-control">
                                            <option value=""></option>
                                            <?php
                                            foreach($category_run as $category_item) {
                                            ?>
                                            <option value="<?= $category_item['category_id'] ?>">
                                                <?= $category_item['classname'] ?>
                                            </option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="col-12 col-md-5">
                                    <div class="mb-2 input-group-sm">
                                        <div class="d-flex justify-content-between">
                                            <label for="book_image">Book Image</label>
                                            <span class="text-muted"><small>(Optional)</small></span>
                                        </div>
                                        <input type="file" name="book_image" id="book_image_input" class="form-control">
                                        <input type="text" id="book_image_name" class="form-control mt-2" readonly>
                                        <!-- Hidden input to hold the existing image filename -->
                                        <input type="hidden" name="existing_image" id="existing_image">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-end">
                                <div>
                                    <a href="books.php" class="btn btn-secondary">Cancel</a>
                                    <button type="submit" name="add_book" class="btn btn-primary">Add Book</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer"></div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php 
include('./includes/footer.php');
include('./includes/script.php');
include('../message.php');
?>

<script>
function generateAccessionFields() {
    const copyCount = document.getElementById('copy').value;
    const container = document.getElementById('accession_numbers_container');
    container.innerHTML = '';
    for (let i = 1; i <= copyCount; i++) {
        const input = document.createElement('input');
        input.type = 'number';
        input.name = 'accession_number_' + i;
        input.className = 'form-control mb-2';
        input.placeholder = 'Accession Number ' + i;
        input.required = true;
        container.appendChild(input);
    }
}

function checkDuplicateAccessionNumbers() {
    const accessionNumbers = [];
    const inputs = document.querySelectorAll('[name^="accession_number_"]');
    
    for (let input of inputs) {
        const accessionNumber = input.value;
        if (accessionNumbers.includes(accessionNumber)) {
            Swal.fire({
                icon: 'error',
                title: 'Duplicate Accession Number',
                text: 'Duplicate accession number ' + accessionNumber + ' found.',
            });
            return false; // Prevent form submission
        }
        accessionNumbers.push(accessionNumber);
    }
    
    return true; // Allow form submission
}

$(document).ready(function() {
    $('#copyright_date').datepicker({
        format: "yyyy",
        viewMode: "years",
        minViewMode: "years",
        autoclose: true,
        clearBtn: true,
        todayHighlight: true
    });
});

function populateBookDetails() {
    const selectedBook = document.getElementById('title_select').value;
    if (selectedBook) {
        const book = JSON.parse(selectedBook);
        document.getElementById('title').value = book.title;
        document.getElementsByName('author')[0].value = book.author;
        document.getElementsByName('copyright_date')[0].value = book.copyright_date;
        document.getElementsByName('publisher')[0].value = book.publisher;
        document.getElementsByName('isbn')[0].value = book.isbn;
        document.getElementsByName('place_publication')[0].value = book.place_publication;
        document.getElementsByName('call_number')[0].value = book.call_number;
        document.getElementsByName('lrc_location')[0].value = book.category_id;

        // Set the image if available
        if (book.book_image) {
            document.getElementById('book_image_name').value = book.book_image;
            document.getElementById('existing_image').value = book.book_image;
        } else {
            document.getElementById('book_image_name').value = '';
            document.getElementById('existing_image').value = '';
        }
    } else {
        // Clear the fields if no book is selected
        document.getElementById('title').value = '';
        document.getElementsByName('author')[0].value = '';
        document.getElementsByName('copyright_date')[0].value = '';
        document.getElementsByName('publisher')[0].value = '';
        document.getElementsByName('isbn')[0].value = '';
        document.getElementsByName('place_publication')[0].value = '';
        document.getElementsByName('call_number')[0].value = '';
        document.getElementsByName('lrc_location')[0].value = '';
        document.getElementById('book_image_preview').style.display = 'none';
    }
}
</script>
