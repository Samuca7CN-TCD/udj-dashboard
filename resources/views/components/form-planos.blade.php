@props(['id', 'name'])

<form id="{{ $id }}" action="#" method="get">
    <label>
        <input name="{{ $name }}" type="radio" value="todos" checked="checked" />
        <span class="tooltipped" data-position="top" data-tooltip="Todos os planos"></span>
    </label>
    <label>
        <input name="{{ $name }}" type="radio" value="mensal" />
        <span class="tooltipped" data-position="top" data-tooltip="Plano mensal"></span>
    </label>
    <label>
        <input name="{{ $name }}" type="radio" value="semestral" />
        <span class="tooltipped" data-position="top" data-tooltip="Plano semestral"></span>
    </label>
    <label>
        <input name="{{ $name }}" type="radio" value="anual" />
        <span class="tooltipped" data-position="top" data-tooltip="Plano anual"></span>
    </label>
</form>