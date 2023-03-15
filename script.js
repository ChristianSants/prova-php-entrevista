$(function(){
    $('.novo').on('click', function(e){
        $.post('views/modal-novo.php', {
        }).done(function(data){
            $('.modal-content').html(data)
            $('.modal').modal({backdrop: 'static', keyboard: true})
            $('.modal').modal('show')

            $('.select2').select2({
                dropdownParent: $('.modal')
            })

            $('.salvar').on('click', function(e){
                let edtName = $('#edtName').val()
                let edtEmail = $('#edtEmail').val()
                let selectColors = $('#selectColors').val()

                $.post('controllers/salvar.php', {
                    edtName, edtEmail,
                    selectColors
                }).done(function(data){
                    $('.msg').html(data)
                })
            })

        }) 
    })

    lista()
})


var lista = () => {
    $.post('views/lista.php', {
    }).done(function(data){
        $('.lista').html(data)
        $('.mascara').fadeOut(1000)
        
        $('.editar').on('click', function(e){
            let id = $(this).parent().parent().attr('userId')
            $.post('views/modal-editar.php', {
                id
            }).done(function(data){
                $('.modal-content').html(data)
                $('.modal').modal({backdrop: 'static', keyboard: true})
                $('.modal').modal('show')

                $('.select2').select2({
                    dropdownParent: $('.modal')
                })
                
                $('.atualizar').on('click', function(e){
                    let edtName = $('#edtName').val()
                    let edtEmail = $('#edtEmail').val()
                    let selectColors = $('#selectColors').val()
    
                    $.post('controllers/atualizar.php', {
                        edtName, edtEmail,
                        selectColors, id
                    }).done(function(data){
                        $('.msg').html(data)
                    })
                })

            })
        })

        $('.excluir').on('click', function(e){
            if(confirm("Tem certeza que deseja excluir?")){
                let id = $(this).parent().parent().attr('userId')
                $.post('controllers/excluir.php',{
                    id
                }).done(function(data){
                    $('.retorno').html(data)
                })
            }
        })

    })
}