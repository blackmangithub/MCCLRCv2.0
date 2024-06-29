<?php 
include('includes/header.php');
include('includes/navbar.php');
include('admin/config/dbcon.php');

if(empty($_SESSION['auth'])){
    // $_SESSION['message_error'] = "<small>Login your Credentials to Access</small>";
    header('Location: home.php');
    exit(0);
}
if($_SESSION['auth_role'] != "student" && $_SESSION['auth_role'] != "faculty")
{
    header("Location:index.php");
    exit(0);
}
?>

<style>
     .center{
          text-align: center;
          margin-top: -20px;
          margin-bottom: 20px;
     }
</style>

<div class="container">
    <div class="row">
        <div class="col-xl-12">
            <div class="card mt-2" data-aos="zoom-in">
                <div class="card-body pt-3">
                    <div>
                        <div id="profile-overview">
                            <div class="row mt-3">

                                <?php
                                $name_hold = $_SESSION['auth_stud']['stud_id'];
                                $query = "SELECT * FROM holds LEFT JOIN book ON holds.book_id = book.book_id
                                          WHERE user_id = '$name_hold' AND hold_status = '' ORDER BY hold_id DESC";

                                $query_run = mysqli_query($con, $query);
                                $book_count = mysqli_num_rows($query_run); // Count the number of held books

                                // Define maximum number of books a user can hold
                                $max_books_hold = 3;

                                if($book_count > 0)
                                {
                                    echo '<h5 class="center">Hold books : '.$book_count.' '.'/'.' '.$max_books_hold.'</h5>'; // Display the count
                                    foreach($query_run as $hold)
                                    {
                                        $hold_book = $hold['hold_id'];
                                        $book_hold = $hold['book_id'];
                                ?>

                                <div class="col-lg-3 col-md-3 label text-center mb-3">
                                    <?php if($hold['book_image'] != ""): ?>
                                    <img src="uploads/books_img/<?php echo $hold['book_image']?>" width="100px"
                                        alt="">
                                    <?php else: ?>
                                    <img src="uploads/books_img/book_image.jpg" alt="">
                                    <?php endif; ?>
                                </div>
                                <div class="col-lg-6 col-md-6 label">
                                    <div>
                                        <?=$hold['title'].' '.$hold['copyright_date'].' by '.$hold['author'];?>
                                    </div>
                                    <div class="text-muted">
                                        <?=date("M d, Y", strtotime($hold['hold_date']));?>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 label text-center mb-3">
                                    <form action="" method="POST">
                                        <button type="submit" value="<?=$hold['hold_id'];?>"
                                            class="btn btn-danger " name="cancel_hold">
                                            Cancel
                                        </button>
                                    </form>
                                </div>

                                <?php
                                    }
                                }
                                else
                                {
                                    echo '<div class="col-lg-12 col-md-12">
                                              <div class="text-center">No held books</div>
                                          </div>';
                                }
                                ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
if(isset($_POST['cancel_hold']))
{
    $holdbook_id = mysqli_real_escape_string($con, $_POST['cancel_hold']);
    $query = "DELETE FROM holds WHERE hold_id ='$holdbook_id'";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $update_copies = mysqli_query($con,"SELECT * FROM book WHERE book_id = '$book_hold' ");
        $copies_row= mysqli_fetch_assoc($update_copies);
          
        $book_copies = $copies_row['copy'];
        $new_book_copies = $book_copies + 1;

        mysqli_query($con,"UPDATE book SET copy = '$new_book_copies' where book_id = '$book_hold' ");

        echo "<script>alert('Book cancelled successfully'); window.location='hold.php'</script>";
    }
    else
    {
        $_SESSION['message_error'] = 'There was something wrong';
        header("Location: hold.php");
        exit(0);
    }
}

include('includes/footer.php');
include('includes/script.php');
include('message.php');
?>
