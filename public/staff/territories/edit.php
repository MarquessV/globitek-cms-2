<?php
require_once('../../../private/initialize.php');

if(!isset($_GET['id'])) {
  redirect_to('index.php');
}
$territories_result = find_territory_by_id($_GET['id']);
// No loop, only one result
$territory = db_fetch_assoc($territories_result);
$ogterritory = $territory;

$errors = array();

if(is_post_request()) {

  // Confirm that values are present before accessing them.
  if(isset($_POST['name'])) { $territory['name'] = $_POST['name']; }
  if(isset($_POST['position'])) { $territory['position'] = $_POST['position']; }

  $result = update_territory($territory);
  if($result === true) {
    redirect_to('show.php?id=' . $territory['id']);
  } else {
    $errors = $result;
  }
}

?>
<?php $page_title = 'Staff: Edit Territory ' . $ogterritory['name']; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <a href="../states/show.php?id=<?php echo urlencode($territory['state_id'])?>">Back to State Details</a><br />

  <h1>Edit Territory: <?php echo $ogterritory['name']; ?></h1>

  <?php echo display_errors($errors); ?>

  <form action="edit.php?id=<?php echo urlencode($territory['id']); ?>" method="post">
    Territory name:<br />
    <input type="text" name="name" value="<?php echo h($territory['name']); ?>" /><br />
    Territory position:<br />
    <input type="text" name="position" value="<?php echo h($territory['position']); ?>" /><br />
    <br />
    <input type="submit" name="submit" value="Update"  />
  </form>

<br>
  <a href="show.php?id=<?php echo urlencode($territory['id']) ?>">Cancel</a>


</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
