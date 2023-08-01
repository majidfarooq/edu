@if($result->id)<input type="hidden" name="course_id" value="{{$result->id}}">@endif
<div class="form-group">
    <label class="form-label" for="bachelorDegree">Program</label>
    <input type="text" name="degree_program" id="degree_program" @if($result->degree_program) value="{{$result->degree_program}}" @endif class="form-control" placeholder="" required>
</div>
<button type="submit" class="btn btn-link w-100">Update</button>
