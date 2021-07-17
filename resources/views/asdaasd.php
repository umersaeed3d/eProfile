@foreach($table as $directory)
                    <ul class="uk-nestable" data-uk-nestable>
                        
                            
                        <li class="uk-nestable-item uk-parent uk-collapsed">
                            <div class="uk-nestable-panel">
                                <div class="uk-nestable-toggle" data-nestable-action="toggle" onclick="sendid({{$directory->id}})"></div>
                                    {{$directory->name}}
                            </div>
                            <ul class="{{$directory->id}}">
                                
                            </ul>
                        </li>
                        
                        
                    </ul>
                    @endforeach