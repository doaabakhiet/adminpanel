@extends('layouts.app')
@section('title', __('lang.contact_us'))
@section('content')
    <div class="content-wrapper">

        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">
                        <h4>@lang('lang.contact_us')</h4>
                    </div>
                    <div class="card-body">
                        @if ($contacts->count())
                            <div style="overflow-y: auto;">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th> # </th>
                                            <th> @lang('lang.name') </th>
                                            <th> @lang('lang.email') </th>
                                            <th> @lang('lang.phone') </th>
                                            <th> @lang('lang.is_show') </th>
                                            <th> @lang('lang.message') </th>
                                            <th>@lang('lang.actions')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($contacts as $index => $contact)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                
                                                <td>{{ $contact->name }}</td>
                                                <td>{{ $contact->email }}</td>
                                                <td>{{ $contact->phone }}</td>
                                                <td>{{ $contact->is_show }}</td>
                                                <td>{!! $contact->message !!}</td>
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button"
                                                            class="btn btn-primary btn-sm dropdown-toggle"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">خيارات
                                                            <span class="caret"></span>
                                                            <span class="sr-only">Toggle Dropdown</span>
                                                        </button>
                                                        <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default"
                                                            user="menu" x-placement="bottom-end"
                                                            style="position: absolute; transform: translate3d(73px, 31px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                            <li>
                                                                <a href="{{ route('contact_us.show', $contact->id) }}"
                                                                     class="btn"><i class="fa fa-eye"></i>
                                                                    @lang('lang.show')</a>
                                                            </li>
                                                            <li class="divider"></li>
                                                            <li>
                                                                <form
                                                                    action="{{ route('contact_us.destroy', $contact->id) }}"
                                                                    method="POST" style="display: inline;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn text-red delete_item">
                                                                        <i class="fa fa-trash"></i> @lang('lang.delete')
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- Pagination Links -->
                            <div class="d-flex justify-content-center">
                                {{ $contacts->links() }}
                            </div>
                        @else
                            <p>No contacts found.</p>
                        @endif
                        <div class="view_modal">

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
