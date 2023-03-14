<?php
// Home
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

Breadcrumbs::for('dashboard', function ($trail) {
    $trail->push('Dashboard', route('home.index'));
});

Breadcrumbs::for('users', function ($trail) {
    $trail->push('User', route('users.index'));
});

Breadcrumbs::for('events', function ($trail) {
    $trail->push('Event', route('events.index'));
});

Breadcrumbs::for('events-create', function ($trail) {
    $trail->parent('events');
    $trail->push('Create', route('events.create'));
});

Breadcrumbs::for('events-edit', function ($trail, $event) {
    $trail->parent('events');
    $trail->push('Edit', route('events.edit', $event));
});

Breadcrumbs::for('events-view', function ($trail, $event) {
    $trail->parent('events');
    $trail->push($event->name, route('events.show', $event->id));
});

Breadcrumbs::for('posts', function ($trail) {
    $trail->push('Post', route('posts.index'));
});

Breadcrumbs::for('posts-create', function ($trail) {
    $trail->parent('posts');
    $trail->push('Create', route('posts.create'));
});

Breadcrumbs::for('posts-edit', function ($trail, $post) {
    $trail->parent('posts');
    $trail->push('Edit', route('posts.edit', $post));
});

Breadcrumbs::for('posts-view', function ($trail, $post) {
    $trail->parent('posts');
    $trail->push($post->title, route('posts.show', $post->id));
});

Breadcrumbs::for('tasks', function ($trail) {
    $trail->push('Task', route('tasks.index'));
});

Breadcrumbs::for('tasks-create', function ($trail) {
    $trail->parent('tasks');
    $trail->push('Create', route('tasks.create'));
});

Breadcrumbs::for('attendance', function ($trail) {
    $trail->push('Attendance', route('attendance.index'));
});

Breadcrumbs::for('roles', function ($trail) {
    $trail->push('Role', route('roles.index'));
});

Breadcrumbs::for('settings', function ($trail) {
    $trail->push('Setting', route('settings.index'));
});

Breadcrumbs::for('customers', function ($trail) {
    $trail->push('Customer', route('customers.index'));
});

Breadcrumbs::for('transactions', function ($trail, $customer) {
    $trail->push('Transaction', route('transactions.index', $customer));
});

Breadcrumbs::for('transactionsAdmin', function ($trail) {
    $trail->push('Transaction Management', route('transactions.admin.index'));
});
