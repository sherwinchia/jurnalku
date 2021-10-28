<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Home
Breadcrumbs::for('admin.dashboard.index', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('admin.dashboard.index'));
});

// Users
Breadcrumbs::for('admin.users.index', function (BreadcrumbTrail $trail) {
    $trail->push('Users', route('admin.users.index'));
});

// Users > Show
Breadcrumbs::for('admin.users.show', function (BreadcrumbTrail $trail, $model) {
    $trail->parent('admin.users.index');
    $trail->push($model->name);
});

// Users > Create
Breadcrumbs::for('admin.users.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.users.index');
    $trail->push('Create');
});

// Users > Edit
Breadcrumbs::for('admin.users.edit', function (BreadcrumbTrail $trail, $model) {
    $trail->parent('admin.users.index');
    $trail->push($model->name);
});

// Packages
Breadcrumbs::for('admin.packages.index', function (BreadcrumbTrail $trail) {
    $trail->push('Packages', route('admin.packages.index'));
});

// Packages > Show
Breadcrumbs::for('admin.packages.show', function (BreadcrumbTrail $trail, $model) {
    $trail->parent('admin.packages.index');
    $trail->push($model->name);
});

// Packages > Create
Breadcrumbs::for('admin.packages.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.packages.index');
    $trail->push('Create');
});

// Packages > Edit
Breadcrumbs::for('admin.packages.edit', function (BreadcrumbTrail $trail, $model) {
    $trail->parent('admin.packages.index');
    $trail->push($model->name);
});

// Transactions
Breadcrumbs::for('admin.transactions.index', function (BreadcrumbTrail $trail) {
    $trail->push('Transactions', route('admin.transactions.index'));
});

// Transactions > Show
Breadcrumbs::for('admin.transactions.show', function (BreadcrumbTrail $trail, $model) {
    $trail->parent('admin.transactions.index');
    $trail->push($model->name);
});

// Transactions > Create
Breadcrumbs::for('admin.transactions.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.transactions.index');
    $trail->push('Create');
});

// Transactions > Edit
Breadcrumbs::for('admin.transactions.edit', function (BreadcrumbTrail $trail, $model) {
    $trail->parent('admin.transactions.index');
    $trail->push($model->name);
});

// Promocodes
Breadcrumbs::for('admin.promocodes.index', function (BreadcrumbTrail $trail) {
    $trail->push('Promocodes', route('admin.promocodes.index'));
});

// Promocodes > Show
Breadcrumbs::for('admin.promocodes.show', function (BreadcrumbTrail $trail, $model) {
    $trail->parent('admin.promocodes.index');
    $trail->push($model->code);
});

// Promocodes > Create
Breadcrumbs::for('admin.promocodes.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.promocodes.index');
    $trail->push('Create');
});

// Promocodes > Edit
Breadcrumbs::for('admin.promocodes.edit', function (BreadcrumbTrail $trail, $model) {
    $trail->parent('admin.promocodes.index');
    $trail->push($model->code);
});
