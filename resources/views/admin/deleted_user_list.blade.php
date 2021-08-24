@extends('layouts.app')
@section('content')


<div class="container">
    <div class="h1 text-center">Deleted User List</div>
    <hr>
    
    <table class="py-3 my-3 table table-striped">
        <thead>
          <tr>
            <th scope="col">No.</th>
            <th scope="col">Name</th>
            <th scope="col">Username</th>
            <th scope="col">Department</th>  
            <th scope="col">Actions</th>  
          </tr>
        </thead>
        <tbody id="deleted_user_list_table_body">
    
        </tbody>   

    </table>

    <div class="mt-2 text-center">
        <button class="btn btn-primary" id="load_more_deleted_users">Load More <i class="fas fa-lg fa-chevron-down mt-1"></i></button>
        <div class="d-flex justify-content-center">
            <div class="spinner-border" role="status" id="deleted_users_loading_spinner" style="display: none">
              <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>
</div>

<script>

var page = 1;

function get_deleted_users()
{
    $('#load_more_deleted_users').hide();
    $('#deleted_users_loading_spinner').show();
    $.ajax({
        url: "{{ route('admin_panel.get_deleted_users') }}",
        type: "GET",
        data: {
            page : page
        },
        success: function(res_data) {
            var count = 1;
            for(let user of res_data)
            {
                $('#deleted_user_list_table_body').append(`
                    <tr>
                        <th>${count}</th>
                        <td>${user.name}</td>
                        <td>${user.username}</td>
                        <td>${user.department}</td>
                        <td><a href="${user.restoring_url}" class="text-dark" onmouseover="tooltip(this)" title="Restore User"><i class="fas fa-undo"></i></a></td>
                    </tr>
                `);

                count++;
            }
            $('#deleted_users_loading_spinner').hide();
            $('#load_more_deleted_users').show();

            if(res_data.length == 0 || (page == 1 && res_data.length < 15) )
            {
                $('#load_more_deleted_users').hide();
                page = 'stop';
            }
        },
        error: function(res_data) {
            alertify.alert('Error', 'Something Went Wrong!');
        }
    });

}

$(document).ready(function(){

    get_deleted_users();

    $('#load_more_deleted_users').click(function(){
        page++;
        get_users();
    });

});

</script>

@endsection
