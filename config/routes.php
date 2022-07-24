<?php
return [
    "" => [ //preg match
        "controller" => "Authorization",
        "action" => "ShowAuthorization"
    ],
    //authorization
    "auth" => [
        "controller" => "Authorization",
        "action" => "ShowAuthorization"
    ],
    "tryauth" => [
        "controller" => "Authorization",
        "action" => "TryAuthorization"
    ],
    //LogOut
    "LogOut" => [
        "controller" => "Authorization",
        "action" => "LogOut"
    ],
    //registration
    "register" => [
    "controller" => "Registration",
    "action" => "ShowRegistration"
    ],
    "tryregister" => [
        "controller" => "Registration",
        "action" => "TryRegistration"
    ],
    //User account
    "myprofile" => [
        "controller" => "UserAccount",
        "action" => "ShowUserAccount"
    ],
    "myprofile/edit" => [
        "controller" => "UserAccount",
        "action" => "ShowEditProfile"
    ],
    "myprofile/tryedit" => [
        "controller" => "UserAccount",
        "action" => "TryEditProfile"
    ],
    "mycourses" => [
        "controller" => "UserAccount",
        "action" => "ShowMyCourses"
    ],
    "listusers" => [
    "controller" => "UserAccount",
    "action" => "ShowListUsers"
    ],
    "mycourses/(\d+)/view" => [
        "controller" => "UserAccount",
        "action" => "ShowSelectedCourse"
    ],
    //adminpanel
    "adminpanel" => [
        "controller" => "AdminPanel",
        "action" => "ShowAdminPanel"
    ],
    //courses
    "courses" => [
        "controller" => "Course",
        "action" => "ShowAllCourses"
    ],
    "courses/create" => [
        "controller" => "Course",
        "action" => "ShowCreateCourse"
    ],
    "courses/trycreate" => [
        "controller" => "Course",
        "action" => "TryCreateCourse"
    ],
    "courses/(\d+)/edit" => [
        "controller" => "Course",
        "action" => "ShowEditCourse"
    ],
    "courses/tryedit" => [
        "controller" => "Course",
        "action" => "TryEditCourse"
    ],
    "courses/(\d+)/view" => [
        "controller" => "Course",
        "action" => "ShowSelectedCourse"
    ],
    "courses/(\d+)/delete" => [
        "controller" => "Course",
        "action" => "DeleteCourse"
    ],
    "courses/(\d+)/recover" => [
        "controller" => "Course",
        "action" => "RecoverCourse"
    ],
    //users
    "users" => [
        "controller" => "User",
        "action" => "ShowAllUsers"
    ],
    "users/create" => [
        "controller" => "User",
        "action" => "ShowCreateUser"
    ],
    "users/trycreate" => [
        "controller" => "User",
        "action" => "TryCreateUser"
    ],
    "users/(\d+)/edit" => [
        "controller" => "User",
        "action" => "ShowEditUser"
    ],
    "users/tryedit" => [
        "controller" => "User",
        "action" => "TryEditUser"
    ],
    "users/(\d+)/view" => [
        "controller" => "User",
        "action" => "ShowSelectedUser"
    ],
    "users/(\d+)/delete" => [
        "controller" => "User",
        "action" => "DeleteUser"
    ],
    "users/(\d+)/recover" => [
        "controller" => "User",
        "action" => "RecoverUser"
    ],
];