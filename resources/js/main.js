tooltip = function(e)
{
  $(e).tooltip('show')
}

add_comment_form_toggle = function(post_id)
{
  if($(`#${post_id}_resume_form_toggle`).is(":visible"))
  {
    $(`#${post_id}_resume_form_toggle`).hide();
  }
  $(`#${post_id}_add_comment`).toggle();
}

upload_resume_button = function(post_id) 
{
  if($(`#${post_id}_add_comment`).is(":visible"))
  {
    $(`#${post_id}_add_comment`).hide();
  }
  $(`#${post_id}_resume_form_toggle`).toggle();                
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

copy_to_clipboard = function(id) {
  
    var copyText = $(`#${id}`).val();
    navigator.clipboard.writeText(copyText);

    /* Alert the copied text */
    alertify.notify("Copied!");
}
