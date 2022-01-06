<li class="{{ Request::is('dashboard*') ? 'active' : '' }}">
    <a href="{!! route('dashboard.index') !!}"><i class="fa fa-dashboard"></i><span>Dashboard</span></a>
</li>
<li class="{{ Request::is('userRegistrations*') ? 'active' : '' }}">
    <a href="{!! route('userRegistrations.index') !!}"><i class="fa fa-edit"></i><span>User Registrations</span></a>
</li>

<li class="{{ Request::is('gameTypes*') ? 'active' : '' }}">
    <a href="{!! route('gameTypes.index') !!}"><i class="fa fa-edit"></i><span>Game Type</span></a>
</li>

<li class="{{ Request::is('tournamentTypes*') ? 'active' : '' }}">
    <a href="{!! route('tournamentTypes.index') !!}"><i class="fa fa-edit"></i><span>Tournament Types</span></a>
</li>

<li class="{{ Request::is('gameTournaments*') ? 'active' : '' }}">
    <a href="{!! route('gameTournaments.index') !!}"><i class="fa fa-edit"></i><span>Tournament Games</span></a>
</li>

<li class="{{ Request::is('transactions*') ? 'active' : '' }}">
    <a href="{!! route('transactions.index') !!}"><i class="fa fa-edit"></i><span>Transactions</span></a>
</li>

<li class="{{ Request::is('playGames*') ? 'active' : '' }}">
    <a href="{!! route('playGames.index') !!}"><i class="fa fa-edit"></i><span>Play Games</span></a>
</li>
<li class="{{ Request::is('rewards*') ? 'active' : '' }}">
    <a href="{!! route('rewards.index') !!}"><i class="fa fa-edit"></i><span>Rewards</span></a>
</li>
<li class="{{ Request::is('rank*') ? 'active' : '' }}">
    <a href="{!! route('rank.index') !!}"><i class="fa fa-edit"></i><span>Player rank</span></a>
</li>
<li class="{{ Request::is('subscriptions*') ? 'active' : '' }}">
    <a href="{!! route('subscriptions.index') !!}"><i class="fa fa-edit"></i><span>Subscriptions</span></a>
</li>

{{--<li class="{{ Request::is('awards*') ? 'active' : '' }}">
    <a href="{{ route('awards.index') }}"><i class="fa fa-edit"></i><span>Awards</span></a>
</li>--}}

<li class="{{ Request::is('banners*') ? 'active' : '' }}">
    <a href="{{ route('banners.index') }}"><i class="fa fa-edit"></i><span>Banners</span></a>
</li>

<li class="{{ Request::is('chips*') ? 'active' : '' }}">
    <a href="{{ route('chips.index') }}"><i class="fa fa-edit"></i><span>Chips</span></a>
</li>

<li class="{{ Request::is('promotions*') ? 'active' : '' }}">
    <a href="{{ route('promotions.index') }}"><i class="fa fa-edit"></i><span>Promotions</span></a>
</li>

<li class="{{ Request::is('withdrawAmounts*') ? 'active' : '' }}">
    <a href="{{ route('withdrawAmounts.index') }}"><i class="fa fa-edit"></i><span>Withdraw Amounts</span></a>
</li>
{{--<li class="{{ Request::is('sendInvitations*') ? 'active' : '' }}">
    <a href="{{ route('sendInvitations.index') }}"><i class="fa fa-edit"></i><span>Send Invitations</span></a>
</li>--}}

{{--<li class="{{ Request::is('refers*') ? 'active' : '' }}">
    <a href="{{ route('refers.index') }}"><i class="fa fa-edit"></i><span>Refers</span></a>
</li>--}}
