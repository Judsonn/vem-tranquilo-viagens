@extends('layouts.app', ['title' => $title])

@push('css')
<link type="text/css" href="{{ asset('argon') }}/vendor/datatables/dist/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<link type="text/css" href="{{ asset('argon') }}/vendor/datatables/dist/css/buttons.bootstrap4.min.css" rel="stylesheet">
<link type="text/css" href="{{ asset('argon') }}/vendor/datatables/dist/css/select.bootstrap4.min.css" rel="stylesheet">
@endpush

@section('content')
    @include('layouts.headers.guest')

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    @yield('infos')
                </div>
            </div>
        </div>

        @include('layouts.footers.auth')
    </div>

    <div class="modal fade" id="modal-infos" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h3 class="modal-title" id="modal-title-default">Informações detalhadas do ônibus</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>

                    <div class="modal-body">

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
                    </div>

                </div>
            </div>
        </div>
@endsection

@push('js')
<script src="{{ asset('argon') }}/vendor/datatables/dist/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('argon') }}/vendor/datatables/dist/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('argon') }}/vendor/datatables/dist/js/dataTables.buttons.min.js"></script>
<script src="{{ asset('argon') }}/vendor/datatables/dist/js/buttons.bootstrap4.min.js"></script>
<script src="{{ asset('argon') }}/vendor/datatables/dist/js/buttons.html5.min.js"></script>
<script src="{{ asset('argon') }}/vendor/datatables/dist/js/buttons.flash.min.js"></script>
<script src="{{ asset('argon') }}/vendor/datatables/dist/js/buttons.print.min.js"></script>
<script src="{{ asset('argon') }}/vendor/datatables/dist/js/dataTables.select.min.js"></script>
<script src="{{ asset('argon') }}/vendor/sweetalert2/dist/sweetalert2.js"></script>

<script>

let table;
let url = window.location.pathname;

$(document).ready( function () {
    table = $('#datatable-basic').DataTable();
});

$('[data-available-id]').on('click', async function () {
    let id = $(this).data('available-id');

    let response = await Swal.fire({
        title: 'Você tem certeza que deseja mudar a disponibilidade desta rodoviária?',
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim, tenho certeza!',
        cancelButtonText: 'Não, cancelar'
    })

    if(response.value){
        axios.delete(`${url}/${id}`)
        .then(data => {
            table.row(`[data-table-row-id="${id}"]`).remove();
            table.draw();
            Swal.fire('Estado da rodoviária alterado com sucesso!', '', 'success')
        })
        .catch((error) => {
            console.error(error);
            Swal.fire('Aconteceu um erro inesperado...', '', 'error' )
        })

    }
})

$('[data-show-id]').on('click', function() {
    let id = $(this).data('show-id');

    axios.get(`${url}/${id}`)
    .then(response => {
        $(".modal-body").html(response.data)
        $("#modal-infos").modal('show');
    })
})
</script>
@endpush
