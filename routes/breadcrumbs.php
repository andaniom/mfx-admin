<?php
// Home
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

Breadcrumbs::for('dashboard', function ($trail) {
    $trail->push('Dashboard', route('home.index'));
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
