@extends("layouts.app")

@section("scripts")
<script>
    function shortenUrl() {
        var url = $('#urlInput').val();
        var unsuspicious = $('#flexCheckChecked').is(':checked');
        $.ajax({
            type: "POST",
            url: '/create-short-code',
            data: {
                url: url,
                unsuspicious: unsuspicious
            },
            success: function(data) {
                $("#urlInput").val(data.url);
                var copyText = document.querySelector("#urlInput");
                copyText.select();
                document.execCommand("copy");
                $("#urlInput").val("");
                toastr.success("Shortened URL copied to clipboard!");
            },
            error: function(e) {
                toastr.error("Error: " + e.responseJSON.message);
            }
        });
    }
</script>
@endsection

@section("styles")
@endsection

@section("content")
<div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
        <header class="mb-auto">
            <div>
                <h3 class="float-md-start mb-0">{{ config('app.name', 'URL Shortener') }}</h3>
                <nav class="nav nav-masthead justify-content-center float-md-end">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                </nav>
            </div>
        </header>

        <main class="px-3">
            <h1>Enter your URL</h1>
            <p class="lead">This shortens your url and it stays active for 30 days.</p>
            <div class="mb-3">
                <input type="text" class="form-control" id="urlInput" placeholder="https://test.com">
            </div>
            <div class="form-check mb-3" style="padding-left: 175px; padding-right: 175px;">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                <label class="form-check-label" for="flexCheckChecked">
                    Create a readable URL
                </label>
            </div>
            <p class="lead">
                <button class="btn btn-lg btn-secondary fw-bold border-white bg-white" onclick="shortenUrl()">Shorten</button>
            </p>
        </main>

        <footer class="mt-auto text-white-50">
            <p><a href="https://cyrexag.com" target="_blank" class="text-white">Cyrex, LLC</a> © 2022</p>
        </footer>
    </div>

@endsection
