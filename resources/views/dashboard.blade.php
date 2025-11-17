<x-app-layout>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Administración de KDT App
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                @if(count($unvalidated) == 0)
                    <h1>¡Felicidades! No hay ningún cadete esperando aprobación</h1>
                @else
                    <h1>Hay <span class="couriers_quantity">{{count($unvalidated)}}</span> cadete/s esperando tu aprobación
                    </h1>

                    <div class='p-6 contenedor'>
                        <table class="min-w-full bg-white border border-gray-300">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 border">User ID</th>
                                    <th class="px-4 py-2 border">Courier ID</th>
                                    <th class="px-4 py-2 border">DNI</th>
                                    <th class="px-4 py-2 border">Nombre</th>
                                    <th class="px-4 py-2 border">Apellido</th>
                                    <th class="px-4 py-2 border">Documentos</th>
                                    <th class="px-4 py-2 border">Area</th>
                                    <!-- <th class="px-4 py-2 border">Vehículos</th> -->
                                    <th class="px-4 py-2 border">Habilitar</th>
                                    <th class="px-4 py-2 border">Rechazar</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($unvalidated as $uv_courier)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-2 border">{{ $uv_courier->user->id }}</td>
                                        <td class="px-4 py-2 border">{{ $uv_courier->id }}</td>
                                        <td class="px-4 py-2 border">{{ $uv_courier->dni }}</td>
                                        <td class="px-4 py-2 border">{{ $uv_courier->user->firstname }}</td>
                                        <td class="px-4 py-2 border">{{ $uv_courier->user->lastname }}</td>
                                        <td class="px-4 py-2 border text-center">
                                            <button class="courier_button see_docs_button" data-docs=@json($uv_courier)>
                                                Ver Documentación
                                            </button>
                                        </td>
                                        <td class="px-4 py-2 border">{{ $uv_courier->area }} km</td>
                                        <!--
                                                    <td class="px-4 py-2 border">
                                                        <button class="courier_button see_vehicles_button"
                                                            data-vehicles=@json($uv_courier->vehicles)>
                                                            Ver vehículos
                                                        </button>
                                                    </td>
                                                    -->
                                        <td class="px-4 py-2 border text-center">
                                            <button class="courier_button validate_button"
                                                data-courier=@json($uv_courier)>Habilitar cadete</button>
                                        </td>
                                        <td class="px-4 py-2 border text-center">
                                            <button class="courier_button unvalidate_button"
                                                data-courier=@json($uv_courier)>Rechazar cadete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

@vite('resources/js/dashboard.js')