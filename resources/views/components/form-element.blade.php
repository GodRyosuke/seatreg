<div class="form-group row">
    <label class="col-sm-2 col-form-label">{{ $label }}</label>
    <div class="col-sm-10">
        @switch($type)
        @case('text')
            <input id={{ $name }} name={{ $name }} type="text" value="{{ old($name) ?: $value }}" class="form-control @error($name) is-invalid @enderror">
            @break
        @case('long')
            <textarea id={{ $name }} name={{ $name }} rows="5" class="form-control">
            </textarea>
            @break
        @case('option')
            <select id={{ $name }} name={{ $name }} class="form-control">
                @foreach(explode(',', $items) as $item)
                    <option value="{{ $item }}"　@if((old($name) ?: $value) == $item) selected @endif>{{ $item }}</option>
                @endforeach
            </select>
            @break
        @case('option_assoc')
            <select id={{ $name }} name={{ $name }} class="form-control">
                @foreach($items as $item_key => $item_value)
                    <option value="{{ $item_key }}"@if((old($name) ?: $value) == $item_key) selected @endif>{{ $item_value }}</option>
                @endforeach
            </select>
            @break
        @case('file')
            <div class="custom-file">
                <input type="file" class="custom-file-input" id={{ $name }} name={{ $name }}>
                <label class="custom-file-label" for="{{ $name }}">ファイルを選択</label>
            </div>
            @break
        @endswitch
        @error($name)
           <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
