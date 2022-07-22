<?php 
return [
    /*
    "" => [
        "filename" => "pages/auth"
    ],
    "users" => [
        "filename" => "pages/users"
    ],
    "users/(\d+)/view" => [
        "filename" => "pages/PageAdminCheckUser"
    ],
    "users/(\d+)/edit" => [
        "filename" => "pages/PageEditUser"
    ],
    "users/create" => [
        "filename" => "pages/PageCreateUser"
    ],
    "auth" => [
        "filename" => "pages/auth"
    ],
    "register" => [
        "filename" => "pages/register"
    ],
    "PageUserAccountEdit" => [
        "filename" => "pages/PageUserAccountEdit"
    ],
    "PageUserAccount" => [
        "filename" => "pages/PageUserAccount"
    ],
    "PageCreateUser" => [
        "filename" => "pages/PageCreateUser"
    ],
    "PageEditUser" => [
        "filename" => "pages/PageEditUser"
    ],
    "PageAdminCheckUser" => [
        "filename" => "pages/PageAdminCheckUser"
    ],
    "PageCreateCourse" => [
        "filename" => "pages/PageCreateCourse"
    ],
    "PageEditCourse" => [
        "filename" => "pages/PageEditCourse"
    ],
    "PageCheckCourse" => [
        "filename" => "pages/PageCheckCourse"
    ],
    "PageTableUsers" => [
        "filename" => "pages/PageTableUsers"
    ],
    "PageTableCourses" => [
        "filename" => "pages/PageTableCourses"
    ],
    "LogOut" => [
        "filename" => "assets/LogOut"
    ],
    "PageAdminPanel" => [
        "filename" => "pages/PageAdminPanel"
    ],
    "courses" => [
        "filename" => "pages/courses"
    ],
    "courses/(\d+)/view" => [
        "filename" => "pages/PageCheckCourse"
    ],
    "courses/(\d+)/edit" => [
        "filename" => "pages/PageEditCourse"
    ],
    "courses/create" => [
        "filename" => "pages/PageCreateCourse"
    ],
    "testview" => [
        "filename" => "app/Courses/Controllers/CourseController"
    ],
    */
    "courses" => [ //preg match
        "controller" => "Course",
        "action" => "ShowAllCourses"
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
];