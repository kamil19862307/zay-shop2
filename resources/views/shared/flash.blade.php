@if($message = flash()->get())
    <div class="container-fluid bg-{{ $message->class() }} py-5">
        <div class="col-md-6 m-auto text-center">
            <h1 class="h1">{{ $message->message() }}</h1>
        </div>
    </div>
@endif
