@extends('layout.master')

@section('content')

    <table class="table table-striped">
        <thead>
        <tr>
            <th>Round Name</th>
            <th>Number of Teams</th>
            <th>Last updated</th>
            <th>Created By</th>
            <th>Created</th>
            <th>Finished</th>
            <th>Active</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($rounds as $round)
            <tr>
                <th><a href="{{ route('round.single', [$round->id]) }}">{{ $round->name }}</a></th>
                <td>{{ $round->numTeams }}</td>
                <td>
                    <span data-toggle="tooltip" data-placement="top" title="{{$round->updated_at }}">
                        {{ Carbon\Carbon::parse($round->updated_at)->diffForHumans() }}
                    </span>
                </td>
                <td>{{ $round->user->name }}</td>
                <td>
                    <span data-toggle="tooltip" data-placement="top" title="{{$round->created_at }}">
                        {{ Carbon\Carbon::parse($round->created_at)->diffForHumans() }}
                    </span>
                </td>
                <td>
                    <span class="glyphicon {{ !($round->status == "Finished") ? 'glyphicon-remove' : 'glyphicon-ok' }}"
                          aria-hidden="true">
                    </span>
                </td>
                <td>
                    <span class="glyphicon {{ !$round->active ? 'glyphicon-remove' : 'glyphicon-ok' }}"
                          aria-hidden="true">

                    </span>
                </td>
                <td>
                    <?php echo Modal::named('edit_name' . $round->id)
                        ->withTitle('Edit Round Name')
                        ->withButton(Button::warning('')->setSize('btn-xs')->withIcon(Icon::pencil()))
                        ->withBody(view('modals.edit_round_name')
                            ->with('id', $round->id)
                            ->with('name', $round->name)
                            ->render())
                    ?>

                    <?php echo Modal::named('delete_round' . $round->id)
                        ->withTitle('Delete Round')
                        ->withButton(Button::danger('')->setSize('btn-xs')->withIcon(Icon::remove()))
                        ->withBody(view('modals.delete_round')
                            ->with('id', $round->id)
                            ->with('name', $round->name)
                            ->with('numTeams', $round->numTeams)
                            ->with('status', $round->status)
                            ->with('active', $round->active)
                            ->render())
                    ?>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $rounds->links() }}

@endsection
