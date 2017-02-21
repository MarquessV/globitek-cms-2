<?php
require_once('../../../private/initialize.php');

if(!isset($_GET['id'])) {
  redirect_to('index.php');
}
$users_result = find_user_by_id($_GET['id']);
// No loop, only one result
$user = db_fetch_assoc($users_result);

// Set default values for all variables the page needs.
$errors = array();

if(is_post_request()) {
  $result = delete_user($user);
  if($result === true) {
    redirect_to('index.php');
  } else {
    echo "Failed to delete user.";
  }
}
?>
<?php $page_title = 'Confirmation: Delete User ' . $user['first_name'] . " " . $user['last_name']; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <a href="index.php">Back to Users List</a><br />
  <br>
  <b> Are you sure you want ot delete user: <?php echo $user['first_name'] . " " . $user['last_name']; ?>? </b> <br>
  <br>
  <form action="delete.php?id=<?php echo urlencode($user['id']); ?>" method="post">
    <input type="submit" name="submit" value="Confirm"/>
  </form>
  <br>
  <a href="show.php?id=<?php echo urlencode($user['id']) ?>">Cancel</a>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
