<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $room->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900" x-init="presenceState()">
                    <div>
                        <h2 class="font-semibold text-lg">Users Here</h2>
                    </div>

                    <template x-for="user in $store.dispatchedStore.usersHere">
                        <div x-text="user.name"></div>
                    </template>
                </div>
            </div>
        </div>
    </div>


    <script>
        function presenceState() {

            Echo.join('room.{{ $room->id }}')
                .here((users) => {
                Alpine.store('dispatchedStore').usersHere = users
            }).joining((user)=>{
                Alpine.store('dispatchedStore').usersHere.push(user)
            }).leaving(user =>{
                Alpine.store('dispatchedStore').usersHere = Alpine.store('dispatchedStore').usersHere.filter(u => u.id !== user.id)
            })
        }
    </script>

    {{-- Alpine js store script --}}

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('dispatchedStore', {usersHere : []});
        });
    </script>


</x-app-layout>
