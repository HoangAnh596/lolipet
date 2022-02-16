@section('title', 'Tạo vai trò')
@extends('layouts.admin.main')
@section('content')
<div class="container-fluid pt-4">
    <div id="alon"></div>
    <form action="" method="POST" enctype="multipart/form-data">
    @csrf
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Tạo vai trò</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Tên vai trò</label>
                            <input type="text" name="name" class="form-control" value="{{old('name')}}" placeholder="Name role">
                            @error('name') <div class="text-danger mt-2">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{route('role.index')}}" class="btn btn-danger">Quay lại</a>
                        <button type="submit" class="btn btn-success float-right">Lưu</button>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Quyền hạn</div>
                    <div class="card-body" id="card_body_permission">
                        @error('permissions_id') <div class="text-danger mb-2">{{ $message }}</div> @enderror
                        @foreach($permissions as $permission)
                            <div class="form-group">
                                <input type="checkbox" name="permissions_id[]" id="{{$permission->id}}" value="{{$permission->id}}"  {{ in_array($permission->id, old('permissions_id', [])) ? 'checked' : '' }}>
                                <label for="{{$permission->id}}">{{$permission->name}}</label>
                            </div> 
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
@section('pagejs')
<script>
    $( "select" )
        .change(function() {
        var str = '';
        js_arr = <?php echo json_encode($role_has_permission); ?>;
        $( "select option:selected" ).each(function() {
            str += $( this ).val() + " ";
        });
            $( "#alon" ).text( str );
                        var cc = '';
            if (str != ' ') {
                // console.log(str);
                $(".check").removeAttr('checked');
                $.each( js_arr, function( key, value ) {
                // console.log(value.role_id, 'role');
                // console.log(value.permission_id, 'permission');
                    if (value.role_id == str) {
                        console.log('ss');
                        cc += $(".check").val();
                        dd(cc);
                        if (cc == value.permission_id) {
                            cc.attr('checked', true);
                        }
                    }
                });
            };
            // if (str != ' ') {
            //         // $(".check").removeAttr('checked');
            //     $(".check").each(function (e){
            //         strs = $( this ).val() + " ";
            //         console.log(strs, 'permission');
            //         console.log(str, 'role');
                    
            //         // if (strs == str) {
            //         //     $('.check').attr( 'checked', true );
            //         // }
            //     });
            // }
        })
        
    .trigger( "change" );

    // var strs = "";
    // $(".check").each(function (e){
    //     // strs = $( this ).val() + " ";
    //     strs = $( this ).val() + " ";
    //     console.log(strs);
    //     console.log(str);
    //     if (strs == str) {
    //         $(this).attr( 'checked', true );
    //     };
    // });

    // var extratitles = document.getElementsByName('permissions_id'); 
    // var strs = '';
    // for (var i = 0; i < extratitles.length; i++) {
    //     console.log(extratitles.item(i).value);
        
    // } 
    

    


    // js_arr = <?php echo json_encode($role_has_permission); ?>;
    // $.each( js_arr, function( key, value ) {
    //     console.log(value.role_id, 'role');
    //     console.log(value.permission_id, 'permission');
    //     if (value.permission_id > str) {
    //         console.log('ss');
    //     };
    // });

    // var skillhtml = checked;

    // // console.log(options);

    
    // $("#card_body_permission").html(skillhtml);

    // <input type="checkbox" name="permissions_id[]" id="{{$permission->id}} permissions_id" value="{{$permission->id}}">
    // <label for="{{$permission->id}}">{{$permission->name}}</label>


    // // js_arr = '<?php echo JSON_encode($permissions);?>';
    // js_arr = JSON.parse('<?php echo JSON_encode($permissions);?>');
    // console.log(js_arr);
</script>
@endsection