<li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-bell"></i>
        @if ($unreadNotifications)
        <span class="badge badge-warning navbar-badge">{{ $unreadNotifications }}</span>
        @endif
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-header">{{ $unreadNotifications }} Notifications</span>
        <div class="dropdown-divider"></div>
        @foreach ($notifications as $notification)
        <a href="{{ $notification->data['url'] ?? false }}?notification_id={{ $notification->id }}" class="dropdown-item @if ($notification->unread())
            text-bold
        @endif">
            <i class="fas fa-envelope mr-2"></i> {{ Str::limit($notification->data['body'] ?? false, 20, '...') }}
            <span class="float-right text-muted text-sm">{{ $notification->created_at->longAbsoluteDiffForHumans() }}</span>
        </a>
        <div class="dropdown-divider"></div>
        @endforeach
        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
    </div>
</li>
