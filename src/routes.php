<?php

use Pecee\SimpleRouter\SimpleRouter;

function student_routes()
{

    SimpleRouter::get('/', 'StudentController@profile');
    SimpleRouter::get('/student_plan', 'StudentController@getStudyPlan');
}


function professor_routes() {}


function admin_routes(): void {}


function authorisation_routes()
{

    SimpleRouter::get('/', function () {
        header('Location: http://localhost/student/authorisation');
        exit;
    });

    SimpleRouter::get('/student/authorisation', 'StudentController@authorisation');
    SimpleRouter::get('/professor/authorisation', 'ProfessorController@authorisation');
    SimpleRouter::get('/admin/authorisation', 'AdminController@authorisation');

    SimpleRouter::post('/student/authorisation', 'StudentController@authorisationHandler');
    SimpleRouter::post('/professor/authorisation', 'ProfessorController@authorisationHandler');
    SimpleRouter::post('/admin/authorisation', 'AdminController@authorisationHandler');
}


function techical_specialist_routes()
{
    student_routes();
    professor_routes();
    admin_routes();
    authorisation_routes();
}
