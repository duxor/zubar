/*
* sacuvanNiz=[
 *   [
 *       opseg: [d1 ?d2]
 *       vrijeme:[t1 t2]
 *   ],
 *   [
 *       opseg: [d3 ?d4]
 *       vrijeme:[t3 t4]
 *   ]
 *   .
 *   .
 *   .
* ];
*
* */
var radnoVr={
    token:'',
    sacuvanNiz:[],
    privremenoSacuvajNiz:[],
    dani:['Ponedeljak','Utorak','Sreda','Četvrtak','Petak','Subota','Nedelja'],
    init:function(_token){
        radnoVr.token=_token;
        $.post('/administracija/index-init',{_token:radnoVr.token},function(data){
            radnoVr.sacuvanNiz=JSON.parse(data);
            $('#radnoVrijemeSacuvano').html(radnoVr.formatirajHtml);
            $('.radnoVrijeme').click(function(){ radnoVr.prikaziModal() });
            $('#izbrisiSve').click(function(){ radnoVr.ukloniSvePrethodno() });
            $('#dodajOpseg').click(function(){ $('#radnoVrijemeForma').fadeIn() });
            $('#dodajRadnoVrijeme').click(function(){ radnoVr.dodajRadnoVrijeme() });
            $('.sacuvajPromjene').click(function(){ radnoVr.sacuvajPromjene() });
            $('#vrijemeOd').datetimepicker({
                inline: true,
                sideBySide: true,
                format: 'HH:mm',
                defaultDate: '2016-05-17 07:00',
            });
            $('#vrijemeDo').datetimepicker({
                inline: true,
                sideBySide: true,
                format: 'HH:mm',
                defaultDate: '2016-05-17 17:00',
            })
        })
    },
    prikaziModal:function(){
        radnoVr.privremenoSacuvajNiz=radnoVr.sacuvanNiz;
        $('#radnoVrijemeSacuvanoModal').html($('#radnoVrijemeSacuvano').html());
        $('#radnoVrijeme').modal('show')
    },
    ukloniSvePrethodno:function(){
        radnoVr.privremenoSacuvajNiz=[];
        $('#radnoVrijemeSacuvanoModal').html('<p>Radno vreme nije definisano. Dodajte opseg.</p>')
    },
    dodajRadnoVrijeme:function(){
        var novi={
            opseg:[$('select[name=dan0]').val(),$('select[name=dan1]').val()],
            vrijeme:[$('#vrijemeOd .timepicker-hour').html()+':'+$('#vrijemeOd .timepicker-minute').html(),
                $('#vrijemeDo .timepicker-hour').html()+':'+$('#vrijemeDo .timepicker-minute').html()]
        };
        radnoVr.privremenoSacuvajNiz.push(novi);
        $('#radnoVrijemeSacuvanoModal').append(radnoVr.vremenskiOkvir(novi.opseg,novi.vrijeme));
    },
    sacuvajPromjene:function(){
        $.post('/administracija/radno-vrijeme-sacuvaj',
            {
                _token:radnoVr.token,
                radno_vrijeme:JSON.stringify(radnoVr.privremenoSacuvajNiz)
            }
            ,function(){
                radnoVr.sacuvanNiz=radnoVr.privremenoSacuvajNiz;
                radnoVr.privremenoSacuvajNiz=[];
                $('#radnoVrijemeSacuvano').html(radnoVr.formatirajHtml());
                $('#radnoVrijeme').modal('hide')
            })
    },
    formatirajHtml:function(){
        var ispis='';
        for(var i=0,max=radnoVr.sacuvanNiz.length; i<max; i++)
            ispis+=radnoVr.vremenskiOkvir(radnoVr.sacuvanNiz[i].opseg,radnoVr.sacuvanNiz[i].vrijeme);
        return ispis;
    },
    vremenskiOkvir:function(danOpseg,vrijemeOpseg){
        return '<div class="col-xs-12">'+
            '<div class="col-xs-7">'+
            radnoVr.dani[danOpseg[0]]+(danOpseg[1]?'-'+radnoVr.dani[danOpseg[1]]:'')+
            '</div>'+
            '<div class="col-xs-5">'+
            vrijemeOpseg[0]+'-'+vrijemeOpseg[1]+
            '</div>'+
            '</div>';
    }
}