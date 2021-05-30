@extends('layouts.app')
@section('content')
<style type="text/css">
    #regiration_form fieldset:not(:first-of-type) {
        display: none;
    }
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card" style="width: 90%;">
                <div class="card-header bg-primary text-light">Nueva receta</div>

                <div class="card-body">
                    <div class="progress mb-4 mt-2">
                        <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>
                    <form id="regiration_form" novalidate action="{{route('receta.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <fieldset>
                            <h4>Seleccione el tipo de plato</h4>

                            <div class="form-group row row-cols-2">
                                @foreach ($tags as $tag)
                                <div class="col custom-control custom-checkbox">
                                    <input name="tag[{{$tag['id']}}]" id="{{$tag['slug']}}" type="checkbox" class="custom-control-input" value="{{$tag['id']}}">
                                    <label for="{{$tag['slug']}}" class="custom-control-label">{{$tag["name"]}}</label>
                                </div>
                                @endforeach
                            </div>
                            @error('tag')
                                <span>
                                    <strong class="text-danger">{{ $message }}</strong>
                                </span>
                            @enderror
                            <input type="button" name="next" class="next btn btn-primary align-self-end" value="Siguiente" />
                        </fieldset>
                        <fieldset>
                            <h4>Seleccione el modo de preparación</h4>
                            <div class="form-group row row-cols-2">
                                @foreach ($means as $mean)
                                @if ($mean["slug"] == "tradicional")
                                <div class="col custom-control custom-radio">
                                    <input name="mean" id={{$mean["slug"]}} type="radio" class="custom-control-input" value={{$mean["id"]}} checked>
                                    <label for="{{$mean["slug"]}}" class="custom-control-label">{{$mean["name"]}}</label>
                                </div>
                                @else
                                <div class="col custom-control custom-radio">
                                    <input name="mean" id={{$mean["slug"]}} type="radio" class="custom-control-input" value={{$mean["id"]}}>
                                    <label for="{{$mean["slug"]}}" class="custom-control-label">{{$mean["name"]}}</label>
                                </div>
                                @endif
                                @endforeach
                            </div>
                            @error('mean')
                                <span>
                                    <strong class="text-danger">{{ $message }}</strong>
                                </span>
                            @enderror
                            <input type="button" name="previous" class="align-self-end previous btn btn-secondary" value="Previo" />
                            <input type="button" name="next" class="align-self-end next btn btn-primary" value="Siguiente" />
                        </fieldset>
                        <fieldset>
                            <h4>Pon un título a la receta</h4>
                            <input type="text" name="title" id="title" class="form-control mb-4" value="{{old('title')}}">
                            @error('title')
                                <span>
                                    <strong class="text-danger">{{ $message }}</strong>
                                </span>
                            @enderror
                            <input type="button" name="previous" class="align-self-end previous btn btn-secondary" value="Previo" />
                            <input type="button" name="next" class="align-self-end next btn btn-primary" value="Siguiente" />
                        </fieldset>
                        <fieldset>
                            <h4>Una pequeña descripción para atraer al público</h4>
                            <textarea class="form-control mb-4" name="description" id="description" rows="2">{{old('description')}}</textarea>
                            @error('description')
                                <span>
                                    <strong class="text-danger">{{ $message }}</strong>
                                </span>
                            @enderror
                            <input type="button" name="previous" class="align-self-end previous btn btn-secondary" value="Previo" />
                            <input type="button" name="next" class="align-self-end next btn btn-primary" value="Siguiente" />
                        </fieldset>
                        <fieldset>
                            <h4>Indique la lista de ingredientes necesarios</h4>
                            <textarea class="form-control mb-4" name="ingredients" id="ingredients" rows="3">{{old('ingredients')}}</textarea>
                            @error('ingredients')
                                <span>
                                    <strong class="text-danger">{{ $message }}</strong>
                                </span>
                            @enderror
                            <input type="button" name="previous" class="align-self-end previous btn btn-secondary" value="Previo" />
                            <input type="button" name="next" class="align-self-end next btn btn-primary" value="Siguiente" />
                        </fieldset>
                        <fieldset>
                            <h4>Describa la preparación de la receta</h4>
                            <textarea class="form-control mb-4" name="preparation" id="ingredients" rows="3">{{old('preparation')}}</textarea>
                            @error('preparation')
                                <span>
                                    <strong class="text-danger">{{ $message }}</strong>
                                </span>
                            @enderror
                            <input type="button" name="previous" class="align-self-end previous btn btn-secondary" value="Previo" />
                            <input type="button" name="next" class="align-self-end next btn btn-primary" value="Siguiente" />
                        </fieldset>
                        <fieldset>
                            <h4>Por último unas fotos del resultado</h4>
                            <div class="mb-3">
                                <label for="images" class="form-label"></label>
                                <input class="form-control" type="file" name="images[]" multiple="" id="images">
                            </div>
                            @error('images')
                                <span>
                                    <strong class="text-danger">{{ $message }}</strong>
                                </span>
                            @enderror
                            <input type="button" name="previous" class="align-self-end previous btn btn-secondary" value="Previo" />
                            <input type="submit" name="submit" class="align-self-end submit btn btn-success" value="Enviar" id="submit_data" />
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            var current = 1,
                current_step, next_step, steps;
            steps = $("fieldset").length;
            $(".next").click(function() {
                current_step = $(this).parent();
                next_step = $(this).parent().next();
                next_step.show();
                current_step.hide();
                setProgressBar(++current);
            });
            $(".previous").click(function() {
                current_step = $(this).parent();
                next_step = $(this).parent().prev();
                next_step.show();
                current_step.hide();
                setProgressBar(--current);
            });
            setProgressBar(current);
            // Change progress bar action
            function setProgressBar(curStep) {
                var percent = parseFloat(100 / steps) * curStep;
                percent = percent.toFixed();
                $(".progress-bar")
                    .css("width", percent + "%")
                    .html(percent + "%");
            }
        });
    </script>
    @endsection