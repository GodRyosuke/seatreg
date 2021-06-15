
<div class="card">
    <div class="card-header">
        <h4>ユーザ情報</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive container">
            <table class="col-sm-12 table table-striped table-md table-hover table-bordered">
            <tr class="row">
                <th class="col-sm-2">属性</th>
                <th class="col-sm-10">値</th>
            </tr>
            <tr class="row">
                <th class="col-sm-2" scope="row">氏名</th>
                <td class="col-sm-10"> {{ $user->name }} </td>
            </tr>
            <tr class="row">
                <th class="col-sm-2" scope="row">OCUID</th>
                <td class="col-sm-10"> {{ $user->ocuid }} </td>
            </tr>
            <tr class="row">
                <th class="col-sm-2" scope="row">職員番号・学籍番号</th>
                <td class="col-sm-10"> {{ $user->primaryid }} </td>
            </tr>
            <tr class="row">
                <th class="col-sm-2" scope="row">メールアドレス</th>
                <td class="col-sm-10">
                {{ $user->email }} <br />
                {{ $user->ocumail }}（{{ $user->ocualias }}）
                </td>
            </tr>
            <tr class="row">
                <th class="col-sm-2" scope="row">区分</th>
                <td class="col-sm-10"> {{ $user->name_e }} </td>
            </tr>
            <tr class="row">
                <th class="col-sm-2" scope="row">職種</th>
                <td class="col-sm-10"> {{ $user->name_p }} </td>
            </tr>
            <tr class="row">
                <th class="col-sm-2" scope="row">所属</th>
                <td class="col-sm-10"> {{ $user->name_d }} </td>
            </tr>
            </table>
        </div>
    </div>
</div>


