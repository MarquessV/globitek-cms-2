<?php

  //
  // COUNTRY QUERIES
  //

  // Find all countries, ordered by name
  function find_all_countries() {
    global $db;
    $sql = "SELECT * FROM countries ORDER BY name ASC;";
    $country_result = db_query($db, $sql);
    return $country_result;
  }

  //
  // STATE QUERIES
  //

  // Find all states, ordered by name
  function find_all_states() {
    global $db;
    $sql = "SELECT * FROM states ";
    $sql .= "ORDER BY name ASC;";
    $state_result = db_query($db, $sql);
    return $state_result;
  }

  // Find all states, ordered by name
  function find_states_for_country_id($country_id=0) {
    // My custom validation
    if(!filter_var($country_id, FILTER_VALIDATE_INT)) {
      $country_id=0;
    }
    global $db;
    $sql = "SELECT * FROM states ";
    $sql .= "WHERE country_id='" . $country_id . "' ";
    $sql .= "ORDER BY name ASC;";
    $state_result = db_query($db, $sql);
    return $state_result;
  }

  // Find state by ID
  function find_state_by_id($id=0) {
    // My custom validation
    if(!filter_var($id, FILTER_VALIDATE_INT)) {
      $id=0;
    }
    global $db;
    $sql = "SELECT * FROM states ";
    $sql .= "WHERE id='" . $id . "';";
    $state_result = db_query($db, $sql);
    return $state_result;
  }

  function validate_state($state, $errors=array()) {
    $errors = validate_state_name($state['name'], $errors);
    $errors = validate_state_code($state['code'], $errors);
    if(!filter_var($state['country_id'], FILTER_VALIDATE_INT)) {
        $errors[] = "Country ID must be an integer";
    }
    return $errors;
  }

  function validate_state_name($name, $errors=array()) {
    if(!has_length($name, array('min' => 2, 'max' => 255))) {
      $errors[] = "State names must be between 2 and 255 characters.";
    }
    if(!valid_symbols($name, array(' '))) {
      $errors[] = "State names can only contain alphabetic characters and spaces.";
    }
    return $errors;
  }

  function validate_state_code($code, $errors=array()) {
    if(!has_length($code, array('min' => 2, 'max' => 3))) {
        $errors[] = "State code must be between 2 and 3 characters";
    }
    if(!ctype_alpha($code)) {
        $errors[] = "State code must use alphabetic characters only.";
    }
    return $errors;
  }

  // Add a new state to the table
  // Either returns true or an array of errors
  function insert_state($state) {
    global $db;

    $errors = validate_state($state);
    if (!empty($errors)) {
      return $errors;
    }

    $sql = "INSERT INTO states ";
    $sql .= "(name, code, country_id) ";
    $sql .= "VALUES (";
    $sql .= "'" . $state['name'] . "',";
    $sql .= "'" . $state['code'] . "',";
    $sql .= "'" . $state['country_id'] . "'";
    $sql .= ");";

    // For INSERT statments, $result is just true/false
    $result = db_query($db, $sql);
    if($result) {
      return true;
    } else {
      // The SQL INSERT statement failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

  // Edit a state record
  // Either returns true or an array of errors
  function update_state($state) {
    global $db;

    $errors = validate_state($state);
    if (!empty($errors)) {
      return $errors;
    }

    $sql = "UPDATE states SET ";
    $sql .= "name='" . $state['name'] . "', ";
    $sql .= "code='" . $state['code'] . "', ";
    $sql .= "country_id='" . $state['country_id'] . "' ";
    $sql .= "WHERE id='" . $state['id'] . "' ";
    $sql .= "LIMIT 1;";

    // For update_state statments, $result is just true/false
    $result = db_query($db, $sql);
    if($result) {
      return true;
    } else {
      // The SQL UPDATE statement failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

  //
  // TERRITORY QUERIES
  //

  // Find all territories, ordered by state_id
  function find_all_territories() {
    global $db;
    $sql = "SELECT * FROM territories ";
    $sql .= "ORDER BY state_id ASC, position ASC;";
    $territory_result = db_query($db, $sql);
    return $territory_result;
  }

  // Find all territories whose state_id (foreign key) matches this id
  function find_territories_for_state_id($state_id=0) {
    // My custom validation
    if(!filter_var($state_id, FILTER_VALIDATE_INT)) {
      $state_id=0;
    }
    global $db;
    $sql = "SELECT * FROM territories ";
    $sql .= "WHERE state_id='" . $state_id . "' ";
    $sql .= "ORDER BY position ASC;";
    $territory_result = db_query($db, $sql);
    return $territory_result;
  }

  // Find territory by ID
  function find_territory_by_id($id=0) {
    // My custom validation
    if(!filter_var($id, FILTER_VALIDATE_INT)) {
      $id=0;
    }
    global $db;
    $sql = "SELECT * FROM territories ";
    $sql .= "WHERE id='" . $id . "';";
    $territory_result = db_query($db, $sql);
    return $territory_result;
  }

  function validate_territory($territory, $errors=array()) {
    $errors = validate_territory_name($territory['name'], $errors);
    // My custom validation
    if(!filter_var($territory['position'], FILTER_VALIDATE_INT)) {
      $errors[] = "Territory position must be an integer.";
    }
    // My custom validation
    if(is_blank($territory['state_id']) || !filter_var($territory['state_id'], FILTER_VALIDATE_INT)) {
      $errors[] = "Invalid State ID, did you manually change the URL?";
    }
    return $errors;
  }

  function validate_territory_name($name, $errors=array()) {
    if(!has_length($name, array('min' => 2, 'max' => 255))) {
      $errors[] = "Territory name must be between 2 and 255 characters.";
    }
    // My custom validation
    if(!valid_symbols($name, array(' '))) {
      $errors[] = "Territory name must contain only alphabetic characters or spaces.";
    }
    return $errors;
  }

  // Add a new territory to the table
  // Either returns true or an array of errors
  function insert_territory($territory) {
    global $db;

    $errors = validate_territory($territory);
    if (!empty($errors)) {
      return $errors;
    }

    $sql = "INSERT INTO territories ";
    $sql .= "(name, state_id, position) ";
    $sql .= "VALUES (";
    $sql .= "'" . $territory['name'] . "',";
    $sql .= "'" . $territory['state_id'] . "',";
    $sql .= "'" . $territory['position'] . "'";
    $sql .= ");";

    // For INSERT statments, $result is just true/false
    $result = db_query($db, $sql);
    if($result) {
      return true;
    } else {
      // The SQL INSERT territoryment failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

  // Edit a territory record
  // Either returns true or an array of errors
  function update_territory($territory) {

    $errors = validate_territory($territory);
    if (!empty($errors)) {
      return $errors;
    }

    $sql = "UPDATE territories SET ";
    $sql .= "name='" . $territory['name'] . "', ";
    $sql .= "position='" . $territory['position'] . "' ";
    $sql .= "WHERE id='" . $territory['id'] . "' ";
    $sql .= "LIMIT 1;";
 
    // For update_territory statments, $result is just true/false
    $result = db_query($db, $sql);
    if($result) {
      return true;
    } else {
      // The SQL UPDATE territoryment failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

  //
  // SALESPERSON QUERIES
  //

  // Find all salespeople, ordered last_name, first_name
  function find_all_salespeople() {
    global $db;
    $sql = "SELECT * FROM salespeople ";
    $sql .= "ORDER BY last_name ASC, first_name ASC;";
    $salespeople_result = db_query($db, $sql);
    return $salespeople_result;
  }

  // To find salespeople, we need to use the join table.
  // We LEFT JOIN salespeople_territories and then find results
  // in the join table which have the same territory ID.
  function find_salespeople_for_territory_id($territory_id=0) {
    // My custom validation
    if(!filter_var($territory_id, FILTER_VALIDATE_INT)) {
      $territory_id=0;
    }
    global $db;
    $sql = "SELECT * FROM salespeople ";
    $sql .= "LEFT JOIN salespeople_territories
              ON (salespeople_territories.salesperson_id = salespeople.id) ";
    $sql .= "WHERE salespeople_territories.territory_id='" . $territory_id . "' ";
    $sql .= "ORDER BY last_name ASC, first_name ASC;";
    $salespeople_result = db_query($db, $sql);
    return $salespeople_result;
  }

  // Find salesperson using id
  function find_salesperson_by_id($id=0) {
    // My custom validation
    if(!filter_var($id, FILTER_VALIDATE_INT)) {
      $id=0;
    }
    global $db;
    $sql = "SELECT * FROM salespeople WHERE id='" . $id . "' LIMIT 1;";
    $salespeople_result = db_query($db, $sql);
    return $salespeople_result;
  }

  function validate_salesperson($salesperson, $errors=array()) {
    $errors = validate_first_name($salesperson['first_name'], $errors);
    $errors = validate_last_name($salesperson['last_name'], $errors);
    $errors = validate_phone($salesperson['phone'], $errors);
    $errors = validate_email($salesperson['email'], $errors);
    return $errors;
  }

  //Source for regex: https://ericholmes.ca/php-phone-number-validation-revisited/
  function validate_phone($phone, $errors=array()) {
    $regex = "/^(\d[\s-]?)?[\(\[\s-]{0,2}?\d{3}[\)\]\s-]{0,2}?\d{3}[\s-]?\d{4}$/i";
    if(!preg_match($regex, $phone)) {
      $errors[] = "Invalid phone number.";
    }
    return $errors;
  }

  function validate_email($email, $errors=array()) {
    if(!filter_var($email, FILTER_VALIDATE_EMAIL) || !has_length($email, array('min' => 2, 'max' => 255))) {
      $errors[] = "Invalid email.";
    } 
    return $errors;
  }

  // My custom validation
  function valid_symbols($subject, $symbols=array()) {
    return ctype_alpha(str_replace($symbols, '', $subject));
  }

  // My custom validation
  function validate_first_name($name, $errors=array()) {
    $symbols = array('-', ',', '.', '\'');
    if (is_blank($name)) {
      $errors[] = "First name cannot be blank.";
    } 
    if (!has_length($name, array('min' => 2, 'max' => 255))) {
      $errors[] = "First name must be between 2 and 255 characters.";
    } 
    if (!valid_symbols($name, $symbols)) {
      $errors[] = "First name can only have alphabetic characters or the symbols: - , . '";
    }
    return $errors;
  }

  // My custom validation
  function validate_last_name($name, $errors=array()) {
    $symbols = array('-', ',', '.', '\'');
    if (is_blank($name)) {
      $errors[] = "Last name cannot be blank.";
    } elseif (!has_length($name, array('min' => 2, 'max' => 255))) {
      $errors[] = "Last name must be between 2 and 255 characters.";
    } elseif (!valid_symbols($name, $symbols)) {
      $errors[] = "Last name can only have alphabetic characters or the symbols: - , . '";
    }
    return $errors;
  }

  // Add a new salesperson to the table
  // Either returns true or an array of errors
  function insert_salesperson($salesperson) {
    global $db;

    $errors = validate_salesperson($salesperson);
    if (!empty($errors)) {
      return $errors;
    }

    $sql = "INSERT INTO salespeople ";
    $sql .= "(first_name, last_name, phone, email) ";
    $sql .= "VALUES (";
    $sql .= "'" . $salesperson['first_name'] . "',";
    $sql .= "'" . $salesperson['last_name'] . "',";
    $sql .= "'" . $salesperson['phone'] . "',";
    $sql .= "'" . $salesperson['email'] . "'";
    $sql .= ");";

    // For INSERT statments, $result is just true/false
    $result = db_query($db, $sql);
    if($result) {
      return true;
    } else {
      // The SQL INSERT statement failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

  // Edit a salesperson record
  // Either returns true or an array of errors
  function update_salesperson($salesperson) {
    global $db;

    $errors = validate_salesperson($salesperson);
    if (!empty($errors)) {
      return $errors;
    }
    $sql = "UPDATE salespeople SET ";
    $sql .= "first_name='" . $salesperson['first_name'] . "', ";
    $sql .= "last_name='" . $salesperson['last_name'] . "', ";
    $sql .= "phone='" . $salesperson['phone'] . "', ";
    $sql .= "email='" . $salesperson['email'] . "' ";
    $sql .= "WHERE id='" . $salesperson['id'] . "' ";
    $sql .= "LIMIT 1;";
    // For update_salesperson statments, $result is just true/false
    $result = db_query($db, $sql);
    if($result) {
      return true;
    } else {
      // The SQL UPDATE statement failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

  // To find territories, we need to use the join table.
  // We LEFT JOIN salespeople_territories and then find results
  // in the join table which have the same salesperson ID.
  function find_territories_by_salesperson_id($id=0) {
    // My custom validation
    if(!filter_var($id, FILTER_VALIDATE_INT)) {
      $id=0;
    }
    global $db;
    $sql = "SELECT * FROM territories ";
    $sql .= "LEFT JOIN salespeople_territories
              ON (territories.id = salespeople_territories.territory_id) ";
    $sql .= "WHERE salespeople_territories.salesperson_id='" . $id . "' ";
    $sql .= "ORDER BY territories.name ASC;";
    $territories_result = db_query($db, $sql);
    return $territories_result;
  }

  //
  // USER QUERIES
  //

  // Find all users, ordered last_name, first_name
  function find_all_users() {
    global $db;
    $sql = "SELECT * FROM users ";
    $sql .= "ORDER BY last_name ASC, first_name ASC;";
    $users_result = db_query($db, $sql);
    return $users_result;
  }

  // Find user using id
  function find_user_by_id($id=0) {
    // My custom validation
    if(!filter_var($id, FILTER_VALIDATE_INT)) {
      $id=0;
    }
    global $db;
    $sql = "SELECT * FROM users WHERE id='" . $id . "' LIMIT 1;";
    $users_result = db_query($db, $sql);
    return $users_result;
  }

  function validate_user($user, $errors=array()) {
    $errors = validate_first_name($user['first_name'], $errors);
    $errors = validate_last_name($user['last_name'], $errors);
    $errors = validate_email($user['email'], $errors);
    $errors = validate_username($user['username'], $errors);
    return $errors;
  }

  function validate_username($username, $errors=array()) {
    $symbols = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '_');
    if(is_blank($username)) {
      $errors[] = "Username cannot be blank.";
    } elseif (!has_length($username, array('max' => 255))) {
      $errors[] = "Username must be less than 255 characters.";
    } elseif (!valid_symbols($username, $symbols)) {
      $errors[] = "Username must use only alphanumeric characters or underscores.";
    }
    return $errors;
  }

  // Add a new user to the table
  // Either returns true or an array of errors
  function insert_user($user) {
    global $db;

    $errors = validate_user($user);
    if (!empty($errors)) {
      return $errors;
    }

    $created_at = date("Y-m-d H:i:s");
    $sql = "INSERT INTO users ";
    $sql .= "(first_name, last_name, email, username, created_at) ";
    $sql .= "VALUES (";
    $sql .= "'" . $user['first_name'] . "',";
    $sql .= "'" . $user['last_name'] . "',";
    $sql .= "'" . $user['email'] . "',";
    $sql .= "'" . $user['username'] . "',";
    $sql .= "'" . $created_at . "'";
    $sql .= ");";
    // For INSERT statments, $result is just true/false
    $result = db_query($db, $sql);
    if($result) {
      return true;
    } else {
      // The SQL INSERT statement failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

  function delete_user($user) {
    global $db;
    if(!filter_var($user['id'], FILTER_VALIDATE_INT)) {
      $user['id'] = 0;
    }
    $sql = "DELETE FROM users WHERE id=" . $user['id'] . ";";
    $result = db_query($db, $sql);
    if($result) {
      return true;
    } else {
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

  // Edit a user record
  // Either returns true or an array of errors
  function update_user($user) {
    global $db;

    $errors = validate_user($user);
    if (!empty($errors)) {
      return $errors;
    }

    $sql = "UPDATE users SET ";
    $sql .= "first_name='" . $user['first_name'] . "', ";
    $sql .= "last_name='" . $user['last_name'] . "', ";
    $sql .= "email='" . $user['email'] . "', ";
    $sql .= "username='" . $user['username'] . "' ";
    $sql .= "WHERE id='" . $user['id'] . "' ";
    $sql .= "LIMIT 1;";
    // For update_user statments, $result is just true/false
    $result = db_query($db, $sql);
    if($result) {
      return true;
    } else {
      // The SQL UPDATE statement failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }
?>
