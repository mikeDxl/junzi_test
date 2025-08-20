<li class="{{ Request::is('reportes-auditoria*') ? 'active' : '' }}">
    <a href="/reportes-auditoria"
        class="flex items-center p-2 text-sm text-gray-700 rounded-lg hover:bg-gray-100 pl-11 dark:text-gray-300 dark:hover:bg-gray-700">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 mr-2">
            <path fill-rule="evenodd"
                d="M3 3.5A1.5 1.5 0 0 1 4.5 2h6.879a1.5 1.5 0 0 1 1.06.44l4.122 4.12A1.5 1.5 0 0 1 17 7.622V16.5a1.5 1.5 0 0 1-1.5 1.5h-11A1.5 1.5 0 0 1 3 16.5v-13Z"
                clip-rule="evenodd" />
        </svg>
        {{ __('Reporte por área') }}
    </a>
</li>

<li class="{{ Request::is('reportes/hallazgos*') ? 'active' : '' }}">
    <a href="/reportes/hallazgos"
        class="flex items-center p-2 text-sm text-gray-700 rounded-lg hover:bg-gray-100 pl-11 dark:text-gray-300 dark:hover:bg-gray-700">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 mr-2">
            <path fill-rule="evenodd"
                d="M3 3.5A1.5 1.5 0 0 1 4.5 2h6.879a1.5 1.5 0 0 1 1.06.44l4.122 4.12A1.5 1.5 0 0 1 17 7.622V16.5a1.5 1.5 0 0 1-1.5 1.5h-11A1.5 1.5 0 0 1 3 16.5v-13Z"
                clip-rule="evenodd" />
        </svg>
        {{ __('Reporte por hallazgo') }}
    </a>
</li>

{{-- <li class="{{ Request::is('areas-auditoria*') ? 'active' : '' }}">
    <a href="/areas-auditoria"
        class="flex items-center p-2 text-sm text-gray-700 rounded-lg hover:bg-gray-100 pl-11 dark:text-gray-300 dark:hover:bg-gray-700">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 mr-2">
            <path fill-rule="evenodd"
                d="M6 3.75A2.75 2.75 0 0 1 8.75 1h2.5A2.75 2.75 0 0 1 14 3.75v.443c.572.055 1.14.122 1.706.2C17.053 4.582 18 5.75 18 7.07v3.469c0 1.126-.694 2.191-1.83 2.54-1.952.599-4.024.921-6.17.921s-4.219-.322-6.17-.921C2.694 12.73 2 11.665 2 10.539V7.07c0-1.321.947-2.489 2.294-2.676A41.047 41.047 0 0 1 6 4.193V3.75Z"
                clip-rule="evenodd" />
        </svg>
        {{ __('Áreas') }}
    </a>
</li>

<li class="{{ Request::is('config-hallazgos*') ? 'active' : '' }}">
    <a href="/config-hallazgos"
        class="flex items-center p-2 text-sm text-gray-700 rounded-lg hover:bg-gray-100 pl-11 dark:text-gray-300 dark:hover:bg-gray-700">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 mr-2">
            <path fill-rule="evenodd"
                d="M8.34 1.804A1 1 0 0 1 9.32 1h1.36a1 1 0 0 1 .98.804l.295 1.473c.497.144.971.342 1.416.587l1.25-.834a1 1 0 0 1 1.262.125l.962.962a1 1 0 0 1 .125 1.262l-.834 1.25c.245.445.443.919.587 1.416l1.473.294a1 1 0 0 1 .804.98v1.361a1 1 0 0 1-.804.98l-1.473.295a6.95 6.95 0 0 1-.587 1.416l.834 1.25a1 1 0 0 1-.125 1.262l-.962.962a1 1 0 0 1-1.262.125l-1.25-.834a6.953 6.953 0 0 1-1.416.587l-.294 1.473a1 1 0 0 1-.98.804H9.32a1 1 0 0 1-.98-.804l-.295-1.473a6.957 6.957 0 0 1-1.416-.587l-1.25.834a1 1 0 0 1-1.262-.125l-.962-.962a1 1 0 0 1-.125-1.262l.834-1.25a6.957 6.957 0 0 1-.587-1.416l-1.473-.294A1 1 0 0 1 1 10.68V9.32a1 1 0 0 1 .804-.98l1.473-.295c.144-.497.342-.971.587-1.416l-.834-1.25a1 1 0 0 1 .125-1.262l.962-.962A1 1 0 0 1 5.38 3.03l1.25.834a6.957 6.957 0 0 1 1.416-.587l.294-1.473Z"
                clip-rule="evenodd" />
        </svg>
        {{ __('Config Hallazgos') }}
    </a>
</li> --}}

<li class="{{ Request::is('trazabilidad_ventas*') ? 'active' : '' }}">
    <a href="/trazabilidad_ventas"
        class="flex items-center p-2 text-sm text-gray-700 rounded-lg hover:bg-gray-100 pl-11 dark:text-gray-300 dark:hover:bg-gray-700">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 mr-2">
            <path fill-rule="evenodd"
                d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-6a.75.75 0 0 1 .75.75v.316a3.78 3.78 0 0 1 1.653.713c.426.33.744.74.925 1.2a.75.75 0 0 1-1.395.55 1.35 1.35 0 0 0-.447-.563 2.187 2.187 0 0 0-.736-.363V9.3c.698.093 1.383.32 1.959.696.787.514 1.29 1.27 1.29 2.13 0 .86-.504 1.616-1.29 2.13-.576.377-1.261.603-1.96.696v.299a.75.75 0 1 1-1.5 0v-.3c-.697-.092-1.382-.318-1.958-.695-.482-.315-.857-.717-1.078-1.188a.75.75 0 1 1 1.359-.636c.08.173.245.376.54.569.313.205.706.353 1.138.432v-2.748a3.782 3.782 0 0 1-1.653-.713C6.9 9.433 6.5 8.681 6.5 7.875c0-.805.4-1.558 1.097-2.096a3.78 3.78 0 0 1 1.653-.713V4.75A.75.75 0 0 1 10 4Z"
                clip-rule="evenodd" />
        </svg>
        {{ __('Trazabilidad ventas') }}
    </a>
</li>

<li class="{{ Request::is('entregas_auditoria*') ? 'active' : '' }}">
    <a href="/entregas_auditoria"
        class="flex items-center p-2 text-sm text-gray-700 rounded-lg hover:bg-gray-100 pl-11 dark:text-gray-300 dark:hover:bg-gray-700">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 mr-2">
            <path
                d="M6.111 11.89A5.5 5.5 0 1 1 15.501 8 .75.75 0 0 0 17 8a7 7 0 1 0-11.95 4.95.75.75 0 0 0 1.06-1.06Z" />
            <path
                d="M10.766 7.51a.75.75 0 0 0-1.37.365l-.492 6.861a.75.75 0 0 0 1.204.65l1.043-.799.985 3.678a.75.75 0 0 0 1.45-.388l-.978-3.646 1.292.204a.75.75 0 0 0 .74-1.16l-3.874-5.764Z" />
        </svg>
        {{ __('Reportes de Control') }}
    </a>
</li>

<li class="{{ Request::is('reporte_entregables_semanal*') ? 'active' : '' }}">
    <a href="/reporte_entregables_semanal"
        class="flex items-center p-2 text-sm text-gray-700 rounded-lg hover:bg-gray-100 pl-11 dark:text-gray-300 dark:hover:bg-gray-700">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 mr-2">
            <path fill-rule="evenodd"
                d="M3 3.5A1.5 1.5 0 0 1 4.5 2h6.879a1.5 1.5 0 0 1 1.06.44l4.122 4.12A1.5 1.5 0 0 1 17 7.622V16.5a1.5 1.5 0 0 1-1.5 1.5h-11A1.5 1.5 0 0 1 3 16.5v-13Z"
                clip-rule="evenodd" />
        </svg>
        {{ __('Reporte Semanal') }}
    </a>
</li>

<li class="{{ Request::is('reporte_entregables_mensual*') ? 'active' : '' }}">
    <a href="/reporte_entregables_mensual"
        class="flex items-center p-2 text-sm text-gray-700 rounded-lg hover:bg-gray-100 pl-11 dark:text-gray-300 dark:hover:bg-gray-700">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 mr-2">
            <path fill-rule="evenodd"
                d="M3 3.5A1.5 1.5 0 0 1 4.5 2h6.879a1.5 1.5 0 0 1 1.06.44l4.122 4.12A1.5 1.5 0 0 1 17 7.622V16.5a1.5 1.5 0 0 1-1.5 1.5h-11A1.5 1.5 0 0 1 3 16.5v-13Z"
                clip-rule="evenodd" />
        </svg>
        {{ __('Reporte Mensual') }}
    </a>
</li>

<li class="{{ Request::is('hallazgo-reporte-duplicado*') ? 'active' : '' }}">
    <a href="/hallazgo-reporte-duplicado"
        class="flex items-center p-2 text-sm text-gray-700 rounded-lg hover:bg-gray-100 pl-11 dark:text-gray-300 dark:hover:bg-gray-700">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 mr-2">
            <path fill-rule="evenodd"
                d="M3 3.5A1.5 1.5 0 0 1 4.5 2h6.879a1.5 1.5 0 0 1 1.06.44l4.122 4.12A1.5 1.5 0 0 1 17 7.622V16.5a1.5 1.5 0 0 1-1.5 1.5h-11A1.5 1.5 0 0 1 3 16.5v-13Z"
                clip-rule="evenodd" />
        </svg>
        {{ __('Reporte Duplicados') }}
    </a>
</li>
