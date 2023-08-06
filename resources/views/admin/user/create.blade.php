<x-app-layout>

    <x-slot name="nav">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark"
                        href="javascript:;">{{ __('Admin') }}</a></li>
                <li class="breadcrumb-item text-sm text-dark active" aria-current="page">{{ __('Users') }}</li>
            </ol>
        </nav>
    </x-slot>


    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Users</h6>
                </div>

                <div class="card-body">
                    <livewire:admin.create-user-form />
                </div>
            </div>
        </div>
        
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-left text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('Name') }}</th>
                                    <th
                                        class="text-left text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('Type') }}</th>
                                    <th
                                        class="text-left text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('Date Registered') }}</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @dd($users) --}}
                                @forelse ($users as $user)
                                    <tr>
                                        <td>
                                            <div class="d-flex pr-2 py-1">
                                                <div class="d-none">
                                                    <img src="" class="avatar avatar-sm me-3"
                                                        alt="user1">
                                                </div>
                                                <div class="mr-auto d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $user->given_name }} {{ $user->family_name }}</h6>
                                                    <p class="text-xs text-secondary mb-0">{{ $user->email }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $user->type }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $user->created_at }}</p>
                                        </td>
                                        <td class="align-middle">
                                            <a href="" class="text-secondary font-weight-bold text-xs"
                                                data-toggle="tooltip" data-original-title="Edit user">
                                                Edit
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    
                                @endforelse
                                
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
