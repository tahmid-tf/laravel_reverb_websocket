<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            #{{ $order->id }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900" x-init="privateClass()">

                    <template x-if="$store.dispatchedStore.dispatched">
                        <div>
                            Order (# <span x-text="$store.dispatchedStore.order.id"></span>) has been dispatched
                        </div>
                    </template>

                    <template x-if="$store.dispatchedStore.delivered">
                        <div>
                            Order (# <span x-text="$store.dispatchedStore.order.id"></span>) has been delivered
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>


    <script>
        function privateClass() {
            Echo.private('orders.{{ $order->id }}').listen('OrderDispatched', (event) => {


                Alpine.store('dispatchedStore').dispatched = true;
                Alpine.store('dispatchedStore').order = event.order
            })

                .listen('OrderDelivered', (event) => {

                    Alpine.store('dispatchedStore').delivered = true;
                    Alpine.store('dispatchedStore').order = event.order
                })
        }
    </script>

    {{-- Alpine js store script --}}

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('dispatchedStore', {dispatched: false, delivered: false, order: null});
        });
    </script>


</x-app-layout>
