@extends('layouts.app')
@section('content')
<style type="text/css">
    #regiration_form fieldset:not(:first-of-type) {
        display: none;
    }
</style>
<script>
    function deleteImage(slug, image_id) {
        const url = '/receta/' + slug + '/' + image_id + '/delete';
        const data = new URLSearchParams();
        data.append('_token', '{{ csrf_token() }}');
        fetch(url, {
            method: "POST",
            body: data,
        }).then(function(res) {
            if(res.status == 503) {
                $('#delete-'+image_id).html('<div class="alert alert-danger ml-5 mr-5" role="alert">La receta debe tener por lo menos una imagen...</div>').removeClass('form-label fancy-file-label')
            } else {
                $('#img-'+image_id).fadeOut();
                $('#delete-'+image_id).fadeOut();
                $('#update-'+image_id).fadeOut();   
            }
        })
    }
</script>
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
                    <form id="regiration_form" action="{{route('receta.update', $recipe->slug)}}" method="post" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <fieldset>
                            <h4>Seleccione el tipo de plato</h4>
                            <div class="form-group row row-cols-2">
                                @foreach ($tags as $key=>$tag)
                                <div class="col custom-control custom-checkbox">
                                    <input name="tag[{{$tag['id']}}]" id="{{$tag['slug']}}" type="checkbox" class="custom-control-input tag-checkbox" value="{{$tag['id']}}"
                                    @php

                                        if(is_array(old('tag')) && in_array($tag->id, old('tag'))){
                                            echo 'checked';
                                        }

                                        if($tag->recipes->where('recipe_id', $recipe->id)->first()) {
                                            if(in_array($tag->recipes->where('recipe_id', $recipe->id)->first()->toArray(), $recipe->tags->toArray())) {
                                                echo 'checked';
                                            }
                                        }
                                    @endphp />
                                    <label for="{{$tag['slug']}}" class="custom-control-label">{{$tag["name"]}}</label>
                                </div>
                                @endforeach
                                <script>
                                    var limit = 4;
                                    $('.tag-checkbox').on('change', function(evt) {
                                        console.log($(".tag-checkbox:checked" ).length);
                                        if($(".tag-checkbox:checked" ).length >= limit) {
                                            this.checked = false;
                                        }
                                    });
                                </script>
                            </div>
                            <input type="button" name="next" class="next btn btn-primary align-self-end" value="Siguiente" />
                            @error('tag')
                                <br>
                                <span>
                                    <strong class="text-danger">{{ $message }}</strong>
                                </span>
                            @enderror
                        </fieldset>
                        <fieldset>
                            <h4>Seleccione el modo de preparación</h4>
                            <div class="form-group row row-cols-2">
                                @foreach ($means as $mean)
                                @if ($mean["slug"] == "tradicional")
                                <div class="col custom-control custom-radio">
                                    <input name="mean" id={{$mean["slug"]}} type="radio" class="custom-control-input" value={{$mean["id"]}} {{(old('mean') == $mean["id"] || $recipe->mean_id == $mean["id"]) ? 'checked' : ''}} checked>
                                    <label for="{{$mean["slug"]}}" class="custom-control-label">{{$mean["name"]}}</label>
                                </div>
                                @else
                                <div class="col custom-control custom-radio">
                                    <input name="mean" id={{$mean["slug"]}} type="radio" class="custom-control-input" value={{$mean["id"]}} {{(old('mean') == $mean["id"] || $recipe->mean_id == $mean["id"]) ? 'checked' : ''}}>
                                    <label for="{{$mean["slug"]}}" class="custom-control-label">{{$mean["name"]}}</label>
                                </div>
                                @endif
                                @endforeach
                            </div>
                            <input type="button" name="previous" class="align-self-end previous btn btn-secondary" value="Previo" />
                            <input type="button" name="next" class="align-self-end next btn btn-primary" value="Siguiente" />
                            @error('mean')
                                <br>
                                <span>
                                    <strong class="text-danger">{{ $message }}</strong>
                                </span>
                            @enderror
                        </fieldset>
                        <fieldset>
                            <h4>Pon un título a la receta</h4>
                            <input type="text" name="title" id="title" class="form-control mb-4" value="{{$recipe->title}}">
                            <input type="button" name="previous" class="align-self-end previous btn btn-secondary" value="Previo" />
                            <input type="button" name="next" class="align-self-end next btn btn-primary" value="Siguiente" />
                            @error('title')
                                <span>
                                    <strong class="text-danger">{{ $message }}</strong>
                                </span>
                            @enderror
                        </fieldset>
                        <fieldset>
                            <h4>Una pequeña descripción para atraer al público</h4>
                            <textarea class="editor form-control mb-4" name="description" id="description" rows="4">{{$recipe->description}}</textarea>
                            <input type="button" name="previous" class="align-self-end previous btn btn-secondary" value="Previo" />
                            <input type="button" name="next" class="align-self-end next btn btn-primary" value="Siguiente" />
                            <div class="" id="char-limit"></div>

                            @error('description')
                                <br>
                                <span>
                                    <strong class="text-danger">{{ $message }}</strong>
                                </span>
                            @enderror
                        </fieldset>
                        <fieldset>
                            <h4>Indique la lista de ingredientes necesarios</h4>
                            <textarea class="editor form-control mb-4" name="ingredients" id="ingredients" rows="3">{{$recipe->ingredients}}</textarea>
                            <input type="button" name="previous" class="align-self-end previous btn btn-secondary" value="Previo" />
                            <input type="button" name="next" class="align-self-end next btn btn-primary" value="Siguiente" />
                            @error('ingredients')
                                <br>
                                <span>
                                    <strong class="text-danger">{{ $message }}</strong>
                                </span>
                            @enderror
                        </fieldset>
                        <fieldset>
                            <h4>Describa la preparación de la receta</h4>
                            <textarea class="editor form-control mb-4" name="preparation" id="preparation" rows="3">{{$recipe->preparation}}</textarea>
                            <input type="button" name="previous" class="align-self-end previous btn btn-secondary" value="Previo" />
                            <input type="button" name="next" class="align-self-end next btn btn-primary" value="Siguiente" />
                            @error('preparation')
                                <br>
                                <span>
                                    <strong class="text-danger">{{ $message }}</strong>
                                </span>
                            @enderror
                        </fieldset>
                        @foreach($recipe_images as $key=>$recipe_image)
                        <fieldset>
                            <h4>Por último unas fotos del resultado</h4>
                            <div class="mb-3">
                                <div id="img-{{$images[$key]->id}}" class="mb-3">
                                    <img class="img-fluid mx-auto d-block" width="200px" src="/{{$recipe_image}}">
                                </div>
                                <label id="update-{{$images[$key]->id}}" for="image-{{$recipe_image}}" class="form-label fancy-file-label"> 
                                    <span class="icon-primary mr-3"><i class="far fa-images"></i></span>
                                    <span id="input-file-{{$recipe_image}}">Sustituir imagen</span>
                                </label>
                                <label id="delete-{{$images[$key]->id}}" class="mt-4 form-label fancy-file-label" onclick="deleteImage('{{$recipe->slug}}', '{{$images[$key]->id}}')"> 
                                    <span class="icon-danger mr-3"><i class="fas fa-trash-alt"></i></span>
                                    <span>Eliminar imagen</span>
                                </label>
                                
                                <input class="form-control fancy-file-input" accept="image/png, image/gif, image/jpeg, image/jpg" type="file" name="images[]" id="image-{{$recipe_image}}">

                            </div>
                            <input type="button" name="previous" class="previous btn btn-secondary" value="Previo" />
                            <input type="button" name="next" class="next btn btn-primary" value="Siguiente" />
                            
                            @error('images')
                                <br>
                                <span>
                                    <strong class="text-danger">{{ $message }}</strong>
                                </span>
                            @enderror
                        </fieldset>
                        @endforeach
                        <fieldset>
                            <h4>Por último unas fotos del resultado</h4>
                            <div class="mb-3">
                                <label for="images" class="form-label fancy-file-label"> 
                                    <span class="icon-primary mr-3"><i class="far fa-images"></i></span>
                                    <span id="input-file">Seleccionar imagenes</span>
                                </label>
                                <input class="form-control fancy-file-input" accept="image/png, image/gif, image/jpeg, image/jpg" type="file" name="images[]" multiple="" id="images">
                            </div>
                            <input type="button" name="previous" class="align-self-end previous btn btn-secondary" value="Previo" />
                            <input type="submit" name="submit" class="align-self-end submit btn btn-success" value="Enviar" id="submit_data" />
                            @error('images')
                                <br>
                                <span>
                                    <strong class="text-danger">{{ $message }}</strong>
                                </span>
                            @enderror
                        </fieldset>
                    </form>
                </div>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
    <script src="{{ asset('ckeditor-5/ckeditor.js') }}"></script>
<script>

        CKEDITOR.replace( 'ingredients' );
        CKEDITOR.replace( 'preparation' );

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

        $('input[type=text]').on('keydown', function(e) {
            if (e.which == 13) {
                e.preventDefault();
            }
        });

        $('input[type=file]').on('change', function() {
            $('#input-file').text('Imagen seleccionada');
            $('#input-file').css('color', '#e3342f');
        });

        $("#description").on('keypress', function() {
            var limit = 250;
            $("#description").attr('maxlength', limit);
            var init = $(this).val().length;
            
            if(init<limit){
                init++;
                $('#char-limit').text(init+'/'+limit); 
            }
        
        });

    </script>
    @endsection