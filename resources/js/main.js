tooltip = function(e)
{
  $(e).tooltip('show')
}

add_comment_form_toggle = function(post_id)
{
  $(`#${post_id}_add_comment`).toggle();
}

upload_resume = function() 
{
  $('.upload_resume').toggle();                
}

share_post_modal = function()
{
  $('#share_post_modal').modal();
}

hide_comments = function(post_id)
{
    $(`#${post_id}_view_comments_btn`).show();
    $(`#${post_id}_hide_comments_btn`).hide();
    $(`#${post_id}_comment_accordion`).collapse('hide');
}