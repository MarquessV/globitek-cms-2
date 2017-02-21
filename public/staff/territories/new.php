<?php
require_once('../../../private/initialize.php');

$errors = array();
$territory = array(
  'name' => '',
  'position' => '',
  'state' => '',
  'state_id' => ''
);

if(!isset($_GET['state_id'])) {
  redirect_to("../states/index.php");
}

$territory['state_id'] = $_GET['state_id'];
$state_result = find_state_by_id($_GET['state_id']);
$state = db_fetch_assoc($state_result);
$territory['state'] = $state['name'];

if(is_post_request()) {
  // Confirm values are present before accessing them.
  if(isset($_POST['name'])) { $territory['name'] = $_POST['name']; }
  if(isset($_POST['position'])) { $territory['position'] = $_POST['position']; }

  $result = insert_territory($territory);
  if($result === true) {
    $new_id = db_insert_id($db);
    redirect_to('show.php?id=' . $new_id);
  } else {
    $errors = $result;
  }

}

?>
<?php $page_title = 'Staff: New Territory'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <a href="../states/show.php?id=<?php echo urlencode($territory['state_id'])?>">Back to State Details</a><br />

  <h1>New Territory</h1>

  <?php echo display_errors($errors); ?>

<form action="new.php?state_id=<?php echo h($territory['state_id'])?>" method="post">
    Territory name:<br />
    <input type="text" name="name" value="<?php echo h($territory['name']); ?>" /><br />
    Territory position:<br />
    <input type="text" name="position" value="<?php echo h($territory['position']); ?>" /><br />
    <input type="submit" name="submit" value="Create"  />
  </form>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
