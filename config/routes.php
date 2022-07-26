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
    "myprofile/update" => [
        "controller" => "UserAccount",
        "action" => "ShowEditProfile"
    ],
    "myprofile/tryupdate" => [
        "controller" => "UserAccount",
        "action" => "TryEditProfile"
    ],
    "courses" => [
        "controller" => "UserAccount",
        "action" => "ShowMyCourses"
    ],
    "listusers" => [
    "controller" => "UserAccount",
    "action" => "ShowListUsers"
    ],
    "listcourses" => [
        "controller" => "UserAccount",
        "action" => "ShowListCourses"
    ],
    "courses/(\d+)/view" => [
        "controller" => "UserAccount",
        "action" => "ShowSelectedCourse"
    ],
    "courses/(\d+)/delete" => [
        "controller" => "UserAccount",
        "action" => "DeleteMyCourse"
    ],
    "courses/(\d+)/recover" => [
        "controller" => "UserAccount",
        "action" => "RecoverMyCourse"
    ],
    //update
    "listcourses/(\d+)/view" => [
        "controller" => "UserAccount",
        "action" => "ShowSelectedCourse"
    ],
    //adminpanel
    "adminpanel" => [
        "controller" => "AdminPanel",
        "action" => "ShowAdminPanel"
    ],
    //courses/catalog
    "courses/catalog" => [
        "controller" => "Course",
        "action" => "ShowAllCourses"
    ],
    "courses/catalog/create" => [
        "controller" => "Course",
        "action" => "ShowCreateCourse"
    ],
    "courses/catalog/trycreate" => [
        "controller" => "Course",
        "action" => "TryCreateCourse"
    ],
    "courses/catalog/(\d+)/update" => [
        "controller" => "Course",
        "action" => "ShowUpdateCourse"
    ],
    "courses/catalog/tryupdate" => [
        "controller" => "Course",
        "action" => "TryUpdateCourse"
    ],
    "courses/catalog/(\d+)/view" => [
        "controller" => "Course",
        "action" => "ShowSelectedCourse"
    ],
    "courses/catalog/(\d+)/delete" => [
        "controller" => "Course",
        "action" => "DeleteCourse"
    ],
    "courses/catalog/(\d+)/recover" => [
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
    "users/(\d+)/update" => [
        "controller" => "User",
        "action" => "ShowUpdateUser"
    ],
    "users/tryupdate" => [
        "controller" => "User",
        "action" => "TryUpdateUser"
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