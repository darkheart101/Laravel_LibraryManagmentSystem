
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" >
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>

<div class="modal" tabindex="-1" role="dialog" id="borrowing_form">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Borrowing Form</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="alert alert-danger" style="display:none"></div>
      <form action="" method="post">
       <div class="modal-body">
            <!-- Borrower -->
            <div class="form-group mb-3">
                <label for="sel1">Borrower:</label>
                <select class="form-control" id="borrower_id">
                    <option id='0'>-</option>
                    @foreach( $Borrowers as $borrower )
                        <option id='{{ $borrower->id }}'>{{ $borrower->lastname.' '.$borrower->firstname}}</option>
                    @endforeach
                </select>
            </div>

            <!-- Book -->
            <div class="form-group mb-3">
                <label for="sel1">Book:</label>
                <select class="form-control" id="book_id">
                    <option id='0'>-</option>
                    @foreach( $Books as $book )
                        <option id='{{ $book->id }}'> {{ $book->title }} </option>
                    @endforeach
                </select>
            </div>

            <!-- Borrow Date  -->
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" style="width:120px;" id="inputGroup-sizing-default">Borrow Date</span>
              </div>
              <input type="text" class="form-control" aria-label="Default" data-date-format="yyyy-mm-dd" aria-describedby="inputGroup-sizing-default" data-provide="datepicker" name="borrow_date" id="borrow_date" readonly>
            </div>

            <!-- Return Date  -->
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" style="width:120px;" id="inputGroup-sizing-default">Return Date</span>
                </div>
                <input type="text" class="form-control" aria-label="Default" data-date-format="yyyy-mm-dd" aria-describedby="inputGroup-sizing-default" data-provide="datepicker" name="return_date" id="return_date" readonly>
              </div>


        </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" name="btn_save_borrowing" id="btn_save_borrowing">Save changes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <input type="hidden" name="form_borrowingid" value="0">
      </div>
    </div>
    </div>
  </div>
</div>

<script>

jQuery(document).ready(function(){
  // start Document ready

  jQuery('#btn_save_borrowing').click(function(e){
    e.preventDefault();

    var borrowingid = $('input[name=form_borrowingid]').val();
    var borrower_id = $("#borrower_id").find('option:selected').attr('id');
    var book_id = $("#book_id").find('option:selected').attr('id');

    var ajaxURI = "{{ route('newborrowing') }}"
    if( borrowingid > 0)
      ajaxURI = "{{ route('updateborrowing') }}";

    $.ajaxSetup({
      headers:
      {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    jQuery.ajax({
      url: ajaxURI,
      method: 'post',
      data: {
        borrowingid: borrowingid,
        book_id: book_id,
        borrower_id: borrower_id,
        borrow_date: jQuery('#borrow_date').val(),
        return_date: jQuery('#return_date').val(),
      },
      success: function(result)
      {
        location.reload();
      },
      error: function (data)
      {
        var response = $.parseJSON(data.responseText);
        jQuery('.alert-danger').html('');
        jQuery.each(response.errors, function(key, value)
        {
          jQuery('.alert-danger').show();
          jQuery('.alert-danger').append('<li>'+value+'</li>');
        });
      }
    });
  });


//end document ready
});




</script>

