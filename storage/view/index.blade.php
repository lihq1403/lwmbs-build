<!doctype html>
<html lang="zh-CN">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Hello, LWMBS!</title>
</head>
<body>

<div class="container">

    @if ($flash_response)

        @if ($flash_response['success_flash_message'])
            <div class="alert alert-success" role="alert">
                {{ $flash_response['success_flash_message'] }}
            </div>
        @endif

        @if ($flash_response['fail_flash_message'])
            <div class="alert alert-danger" role="alert">
                {{ $flash_response['fail_flash_message'] }}
            </div>
        @endif

    @endif

    <div class="jumbotron">
        <p class="lead">
            @if ($auth->isLogin())
                <h1>Hello, {{ $auth->user()['login'] }}!</h1>
                <a class="btn btn-secondary btn-lg" href="/oauth/logout" role="button">Logout</a>
                <hr class="my-4">
                <form method="post" action="/workflow/run">
                    <div class="form-group row">
                        <label for="source_repo" class="col-sm-2 col-form-label">Source Repo</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="source_repo" name="source_repo" placeholder="Source Repo" value="{{ $source_repo_name }}" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="forked_repo" class="col-sm-2 col-form-label">Forked Repo</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="forked_repo" name="forked_repo" placeholder="Forked Repo" value="{{ $forked_repo_name }}" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-2">libraries</div>
                        <div class="col-sm-10">

                            @foreach ($allow_libraries as $library)
                                <div class="form-check custom-control-inline">
                                    <input class="form-check-input" type="checkbox" id="libraries_{{ $library }}" name="libraries_{{ $library }}" checked>
                                    <label class="form-check-label" for="libraries_{{ $library }}">
                                        {{ $library }}
                                    </label>
                                </div>
                            @endforeach

                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-2">Extensions</div>
                        <div class="col-sm-10">

                            @foreach ($allow_extensions as $extension)
                                <div class="form-check custom-control-inline">
                                    <input class="form-check-input" type="checkbox" id="extensions_{{ $extension }}" name="extensions_{{ $extension }}" checked>
                                    <label class="form-check-label" for="extensions_{{ $extension }}">
                                        {{ $extension }}
                                    </label>
                                </div>
                            @endforeach

                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-2">Workflows</div>
                        <div class="col-sm-10">

                            @foreach ($allow_workflows as $workflow)
                                <div class="form-check custom-control-inline">
                                    <input class="form-check-input" type="checkbox" id="workflows_{{ $workflow }}" name="workflows_{{ $workflow }}" checked>
                                    <label class="form-check-label" for="workflows_{{ $workflow }}">
                                        {{ $workflow }}
                                    </label>
                                </div>
                            @endforeach

                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Run Workflow</button>
                        </div>
                    </div>

                </form>

            @else
                <a class="btn btn-dark btn-lg" href="/oauth/login" role="button">GitHub Login</a>
            @endif
        </p>
    </div>

</div>

</body>
</html>