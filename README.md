# Project 2 - Input/Output Sanitization

Time spent: **7** hours spent in total

## User Stories

The following **required** functionality is completed:

1\. [x]  Required: Import the Starting Database

2\. [x]  Required: Set Up the Starting Code

3\. [x]  Required: Review code for Staff CMS for Users

4\. [x]  Required: Complete Staff CMS for Salespeople
  * [x]  Required: index.php
  * [x]  Required: show.php
  * [x]  Required: new.php
  * [x]  Required: edit.php

5\. [x]  Required: Complete Staff CMS for States
  * [x]  Required: index.php
  * [x]  Required: show.php
  * [x]  Required: new.php
  * [x]  Required: edit.php

6\. [x]  Required: Complete Staff CMS for Territories
  * [x]  Required: index.php
  * [x]  Required: show.php
  * [x]  Required: new.php
  * [x]  Required: edit.php
7\. [x]  Required: Add Data Validations * [x]  Required: Validate that no values are left blank.
  * [x]  Required: Validate that all string values are less than 255 characters.
  * [x]  Required: Validate that usernames contain only the whitelisted characters.
  * [x]  Required: Validate that phone numbers contain only the whitelisted characters.
  * [x]  Required: Validate that email addresses contain only whitelisted characters.
  * [x]  Required: Add *at least 5* other validations of your choosing.

8\. [x]  Required: Sanitization
  * [x]  Required: All input and dynamic output should be sanitized.
  * [x]  Required: Sanitize dynamic data for URLs
  * [x]  Required: Sanitize dynamic data for HTML
  * [x]  Required: Sanitize dynamic data for SQL

9\. [x]  Required: Penetration Testing
  * [x]  Required: Verify form inputs are not vulnerable to SQLI attacks.
  * [x]  Required: Verify query strings are not vulnerable to SQLI attacks.
  * [x]  Required: Verify form inputs are not vulnerable to XSS attacks.
  * [x]  Required: Verify query strings are not vulnerable to XSS attacks.
  * [x]  Required: Listed other bugs or security vulnerabilities

Manipulation of GET requests by manually tampering with the URL proved to be dangerous. In all of the starting code lookups passed the ID directly to a function that performed a SQL query without validating it. To fix this, I updated to lookup functions to check if the value passed in was an integer.


The following advanced user stories are optional:

- [x]  Bonus: On "public/staff/territories/show.php", display the name of the state.

- [x]  Bonus: Validate the uniqueness of `users.username`.

- [x]  Bonus: Add a page for "public/staff/users/delete.php".

- [ ]  Bonus: Add a Staff CMS for countries.

- [ ]  Advanced: Nest the CMS for states inside of the Staff CMS for countries


## Video Walkthrough

Here's a walkthrough of implemented user stories:

<img src='http://i.imgur.com/VIW7AFr.gif' title='Users Walkthrough' width='' alt='Users Walkthrough' />
<img src='http://i.imgur.com/1XgzrHs.gif' title='Sales Walkthrough' width='' alt='Sales Walkthrough' />
<img src='http://i.imgur.com/m7CSg2X.gif' title='States Walkthrough' width='' alt='States Walkthrough' />

GIF created with [LiceCap](http://www.cockos.com/licecap/).

## Notes

It is very tedious make sure all your code is safe from potential exploits. While I think I covered everything here it is hard to ever really be sure your code is 100% safe.

## License

    Copyright [2017] [Marquess Valdez]

    Licensed under the Apache License, Version 2.0 (the "License");
    you may not use this file except in compliance with the License.
    You may obtain a copy of the License at

        http://www.apache.org/licenses/LICENSE-2.0

    Unless required by applicable law or agreed to in writing, software
    distributed under the License is distributed on an "AS IS" BASIS,
    WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
    See the License for the specific language governing permissions and
    limitations under the License.
