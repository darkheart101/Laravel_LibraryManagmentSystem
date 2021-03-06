@extends('layouts.app')


@section('content')

<div class="container">
    <div class="row" style="padding-top:10px;">
        <h2>Borrowings</h2>

        <table class="table">
            <thead>
                <tr>
                    <th >Borrow Date</th>
                    <th >Return Date</th>
                    <th >Borrower</th>
                    <th >Book Title</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($borrowing_records as $borrowing_record)
                    <tr>
                        <td>{{ $borrowing_record->borrow_date }}</td>
                        <td>{{ $borrowing_record->return_date }}</td>

                        <td>
                            @foreach ($borrowing_record->borrowerBorrowed as $borrower)
                                {{ $borrower->firstname }} {{ $borrower->lastname }}
                            @endforeach
                        </td>

                        @foreach ($borrowing_record->booksBorrowed as $book)
                            <td>
                                {{ $book->title }}
                            </td>
                        @endforeach
                        <td>
                            <button type="button" name="btn_edit_borrowing" class="btn btn-success" id="{{ $borrowing_record->id }}">Edit</button>
                        </td>
                        <td>
                            <button type="button" name="btn_del_borrowing" class="btn btn-danger" id=" {{ $borrowing_record->id }} " >Delete</button>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="4" style="text-align: center;">
                        {{ $borrowing_records->links() }}
                    </td>
                </tr>
            </tbody>
        </table>


    </div>
</div>

<script>
$(document).ready(function() {

    $("button[name=btn_edit_borrowing]").click(function(){
        borrowingid = $(this).attr("id");


        jQuery.ajax({
            url: "/borrowing/"+borrowingid,
            method: 'get',
            data: {
                id: borrowingid
            },
            success: function(result)
            {
                $('#borrowing_form').modal('show');
                var borrowers = result.borrower_borrowed;
                borrowers.forEach(function(borrower) {
                    $('select#borrower_id option[id='+borrower.id+']')[0].setAttribute('selected','selected');
                });

                var books = result.books_borrowed;
                books.forEach(function(book) {
                    $('select#book_id option[id='+book.id+']')[0].setAttribute('selected','selected');
                });
                $("input[name=borrow_date]").val(result.borrow_date)
                $("input[name=return_date]").val(result.return_date)
                $("input[name=form_borrowingid]").val(borrowingid)
            },
            error: function (data)
            {
                // TODO: error message
            }

        });
    });

    $("button[name=btn_del_borrowing]").click(function(){
        borrowingid = $(this).attr("id");

        $.ajaxSetup({
            headers:
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        jQuery.ajax({
            url: "/borrowing/"+borrowingid,
            method: 'delete',
            data: {
                id: borrowingid
            },
            success: function(result)
            {
                location.reload();
            },
            error: function (data)
            {
                // TODO: error message
            }

        });
    });
});
</script>

@include('forms.borrowing')
@endsection

