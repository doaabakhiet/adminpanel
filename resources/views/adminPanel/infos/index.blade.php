@extends('layouts.app')
@section('title', __('lang.infos'))
@section('content')
    <div class="content-wrapper">

        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">
                        <h4>@lang('lang.infos')</h4>
                    </div>
                    <div class="row justify-content-end pt-2 pr-3">
                        <div class="col-auto">
                            <a href="{{route('infos.create')}}" class="btn btn-primary">
                                @lang('lang.add')
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($infos->count())
                            <div style="overflow-y: auto;">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th> # </th>
                                            <th> @lang('lang.image') </th>
                                            <th> @lang('lang.title') </th>
                                            {{-- <th> @lang('lang.description') </th> --}}
                                            <th>@lang('lang.actions')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($infos as $index => $info)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td class="text-center">
                                                    @php
                                                        $image = App\Models\info::find(
                                                            $info->info_id,
                                                        )->getFirstMediaUrl('images');
                                                    @endphp

                                                    <img src="{{ $image }}" alt="Image for info" width="400"
                                                        height="400">

                                                </td>
                                                <td>{{ $info->title }}</td>
                                                {{-- <td>
                                                    <div style="max-width: 200px;overflow-wrap: break-word;font-size: 12px;">
                                                        {!! $info->description !!}
                                                    </div>
                                                </td> --}}

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
                                                                <a href="{{ route('infos.edit', $info->info_id) }}"
                                                                     class="btn"
                                                                    ><i class="fa fa-edit"></i>
                                                                    @lang('lang.update')</a>
                                                            </li>
                                                            <li class="divider"></li>
                                                            <li>
                                                                <form action="{{ route('infos.destroy', $info->info_id) }}"
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
                                {{ $infos->links() }}
                            </div>
                        @else
                            <p>No infos found.</p>
                        @endif
                        <div class="view_modal">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Button trigger modal -->
    </div>
@endsection
