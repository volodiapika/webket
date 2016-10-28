            <div class="panel-footer">
                <div class="input-group">
                  <div class="container">
                      @if (isset($message))
                          {!! Form::model($message, array('url' => URL::to('message'), 'method' => 'put', 'id' => 'jform', 'class' => 'bf', 'files'=> false )) !!}
                      @else
                          {!! Form::open(array('url' => URL::to('message'), 'method' => 'post', 'class' => 'bf', 'id' => 'jform', 'files' => false)) !!}
                      @endif
                          <div class="row-send">
                              <p class="text-muted">Message</p>
                              {!! Form::textarea('message', '', array('class' => 'form-control')) !!}
                          </div>
                          <div class="row-send">
                              <p class="text-muted">Title</p>
                              {!! Form::text('title', '', array('class' => 'form-control')) !!}
                          </div>
                          <div class="row-send">
                              <p class="text-muted">Password</p>
                              {!! Form::password('password', '', array('class' => 'form-control')) !!}
                          </div>
                          <div class="row-send">
                              <p class="text-muted">Destroy message after </p>
                              <p class="text-muted">the first link visit</p>
                              {!! Form::radio('status', 0, array('class' => 'form-control')) !!}
                              <p class="text-muted">1 hour</p>
                              {!! Form::radio('status', 1, array('class' => 'form-control')) !!}
                          </div>
                          <div class="row-send">
                               <p class="text-muted"></p>
                               <button class="btn btn-default" type="submit">Send</button>
                          </div>
                      </form>
                  </div>
                </div>
            </div>
          </div>
        </div>
    </div>
</div>