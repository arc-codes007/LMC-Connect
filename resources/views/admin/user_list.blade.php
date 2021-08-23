@extends('layouts.app')
@section('content')


<div class="container">
    <div class="h1 text-center">Saved Posts</div>
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
        <tbody id="user_list_table_body">
    
        </tbody>   

    </table>

    <div class="mt-2 text-center">
        <button class="btn btn-primary" id="load_more_users">Load More <i class="fas fa-lg fa-chevron-down mt-1"></i></button>
        <div class="d-flex justify-content-center">
            <div class="spinner-border" role="status" id="users_loading_spinner" style="display: none">
              <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>
</div>

<script>

var page = 1;

function get_users()
{
    $('#load_more_users').hide();
    $('#users_loading_spinner').show();
    $.ajax({
        url: "{{ route('admin_panel.get_users') }}",
        type: "GET",
        data: {
            page : page
        },
        success: function(res_data) {
            var count = 1;
            for(let user of res_data)
            {
                $('#user_list_table_body').append(`
                    <tr>
                        <th>${count}</th>
                        <td><a href="${user.user_view_url}" class="text-dark">${user.name}</a></td>
                        <td><a href="${user.user_view_url}" class="text-dark">${user.username}</a></td>
                        <td>${user.department}</td>
                        <td><a href="${user.user_settings_url}" class="text-dark"><i class="fas fa-cog"></i></a></td>
                    </tr>
                `);

                count++;
            }
            $('#users_loading_spinner').hide();
            $('#load_more_users').show();

            if(res_data.length == 0)
            {
                $('#load_more_users').hide();
                page = 'stop';
            }
        },
        error: function(res_data) {
            alertify.alert('Error', 'Something Went Wrong!');
        }
    });

}

$(document).ready(function(){

    get_users();

    $('#load_more_users').click(function(){
        page++;
        get_users();
    });

});

</script>

@endsection
