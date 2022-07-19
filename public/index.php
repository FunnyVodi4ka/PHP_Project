<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/routes/startroutes.php';

$routes = require_once($_SERVER['DOCUMENT_ROOT'].'/routes/routes.php');

startRoute($routes);

/*
require('../assets/Router.php');
Router::route('/users', function(){
  include '../pages/users.php';
  die();
});
Router::route('/register', function(){
  include '../pages/register.php';
  die();
});
Router::route('/auth', function(){
  include '../pages/auth.php';
  die();
});
Router::route('/PageUserAccountEdit', function(){
  include '../pages/PageUserAccountEdit.php';
  die();
});
Router::route('/PageUserAccount', function(){
  include '../pages/PageUserAccount.php';
  die();
});
Router::route('/PageCreateUser', function(){
  include '../pages/PageCreateUser.php';
  die();
});
Router::route('/PageEditUser', function(){
  include '../pages/PageEditUser.php';
  die();
});
Router::route('/PageAdminCheckUser', function(){
  include '../pages/PageAdminCheckUser.php';
  die();
});
Router::route('/PageCreateCourse', function(){
  include '../pages/PageCreateCourse.php';
  die();
});
Router::route('/PageEditCourse', function(){
  include '../pages/PageEditCourse.php';
  die();
});
Router::route('/PageAdminCheckCourse', function(){
  include '../pages/PageAdminCheckCourse.php';
  die();
});
Router::route('/PageTableUsers', function(){
  include '../pages/PageTableUsers.php';
  die();
});
Router::route('/PageTableCourses', function(){
  include '../pages/PageTableCourses.php';
  die();
});
Router::route('/LogOut', function(){
  include '../assets/LogOut.php';
  die();
});
Router::execute($_SERVER['REQUEST_URI']);
*/
