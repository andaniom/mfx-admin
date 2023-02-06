<?php
// Home
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

Breadcrumbs::for('dashboard', function ($trail) {
    $trail->push('Dashboard', route('home.index'));
});

Breadcrumbs::for('user', function ($trail) {
    $trail->push('User', route('users.index'));
});

Breadcrumbs::for('event', function ($trail) {
    $trail->push('Event', route('events.index'));
});

Breadcrumbs::for('event-create', function ($trail) {
    $trail->parent('event');
    $trail->push('Create', route('events.create'));
});

Breadcrumbs::for('event-view', function ($trail, $event) {
    $trail->parent('event');
    $trail->push($event->name, route('events.view', $event->id));
});

Breadcrumbs::for('post', function ($trail) {
    $trail->push('Post', route('posts.index'));
});

Breadcrumbs::for('post-create', function ($trail) {
    $trail->parent('post');
    $trail->push('Create', route('posts.create'));
});

Breadcrumbs::for('post-view', function ($trail, $post) {
    $trail->parent('post');
    $trail->push($post->title, route('posts.view', $post->id));
});

Breadcrumbs::for('task', function ($trail) {
    $trail->push('Task', route('tasks.index'));
});

Breadcrumbs::for('task-create', function ($trail) {
    $trail->parent('task');
    $trail->push('Create', route('tasks.create'));
});

Breadcrumbs::for('attendance', function ($trail) {
    $trail->push('Attendance', route('attendance.index'));
});
