@extends('zubar.master')
@section('container')
    {!!Html::style('/css/fileinput.min.css')!!}
    {!!Html::script('/js/fileinput.min.js')!!}
    <div class="col-xs-12"><input type="file" class="file" name="slike[]" multiple id="slikeKorisnika"></div>
    <div class="fotosi col-xs-12"></div>
    <script>
        $(function(){
            $('#slikeKorisnika').fileinput('clear');
            $("#slikeKorisnika").fileinput();
            $("#slikeKorisnika").fileinput('refresh',{
                uploadExtraData:function(){
                    return {_token:'{{csrf_token()}}'}
                },
                uploadUrl: '/administracija/galerija-dodaj-foto',
                uploadAsync: true,
                maxFileCount: 100,
                allowedFileTypes:['image'],
                msgFilesTooMany: 'Broj selektovanih fotografija ({n}) je veći od dozvoljenog ({m}). Pokušajte ponovo!',
                msgInvalidFileType: 'Neispravan tip fajla "{name}". Dozvoljene su samo fotografije.',
                removeLabel: 'Ukloni'
            });
            ucitajFotose();
            $('#slikeKorisnika').on('fileuploaded', function(event, data, previewId, index) {
                ucitajFotose()
            })
        })
        function ucitajFotose(podaci){
            $('.fotosi').html('<center><i class="icon-spin6 animate-spin" style="font-size: 350%"></i></center>');
            $.post('/administracija/galerija-ucitaj-foto',{_token:'{{csrf_token()}}'},function(data){
                prikaziFotografije(data)
            })
        }
        function prikaziFotografije(data){
            data=JSON.parse(data);
            $('.fotosi').html('');
            for(var i in data)
                $('.fotosi').append('<div class="col-sm-4"><img src="'+data[i]+'" data-brisi="0" onclick="zaBrisanje(this)"></div>')
        }
        var fotoZaBrisanje=[];
        function zaBrisanje(foto){
            if($(foto).data('brisi')==0){
                $(foto).data('brisi',1);
                fotoZaBrisanje.push($(foto).attr('src'));
                $(foto).css('opacity','0.5');
            }else{
                $(foto).data('brisi',0);
                for(var i in fotoZaBrisanje)
                    if(fotoZaBrisanje[i] == $(foto).attr('src'))
                        fotoZaBrisanje.splice(i, 1);
                $(foto).css('opacity','1');
            }
            $('#brisiFoto').hide();
            if(fotoZaBrisanje.length>0) $('.fotosi').after('<button id="brisiFoto" class="btn btn-danger" onclick="ukloniSelektovane()">Ukloni fotografije</button>');
        }
        function ukloniSelektovane(){
            $.post('/administracija/galerija-ukloni-foto',{_token:'{{csrf_token()}}',fotosi:JSON.stringify(fotoZaBrisanje)},function(data){
                fotoZaBrisanje=[];
                $('#brisiFoto').hide();
                prikaziFotografije(data)
            })
        }

    </script>
    <style>
        .fotosi{ padding-top: 50px }
        .col-sm-4 img{ width:100% }
    </style>
@endsection