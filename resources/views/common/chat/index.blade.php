<div class="message-wrapper">
    <ul class="messages">
        @foreach($messages as $message)

        <li class="message clearfix">
            <div class="{{ ($message->sender == Auth::id()) ? 'sent' : 'received'}}">
                <p>{{$message->message}}</p>
                <p class="date">{{date('d M y, h:i a', strtotime($message->created_at)) }}</p>
            </div>
        </li>
        @endforeach

    </ul>
</div>
<!-- 
<div class="input-text center">
    <input type="text" name="message" class="submit" autofocus>
    <div class="input-group-append"><span class="input-group-text">
            <svg class="c-icon">
                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-envelope-open"></use>
            </svg></span></div>
</div> -->
<div class="form-group row">
    <div class="col-md-12 ">
        <div class="input-group input-text center">
            <input class="form-control " type="text" name="message" class="submit" autofocus>
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit" onclick="send()"><svg class="c-icon">
                        <use xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-paper-plane"></use>
                    </svg>
                </button>

                <!-- <span class="input-group-text">
                    <svg class="c-icon">
                        <use xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-paper-plane"></use>
                    </svg></span> -->
            </div>

        </div>
    </div>
</div>