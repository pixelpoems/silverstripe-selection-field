<ul $AttributesHTML>
    <% loop $Options %>
        <li class="$Class">
            <input id="$ID" class="radio" name="$Name" type="radio" value="$Value"<% if $isChecked %> checked<% end_if %><% if $isDisabled %> disabled<% end_if %> />
            <label for="$ID" class="icon  <% if not $Icon %>no-icon<% end_if %>">
                <% if $Icon %>
                    <i data-feather="$Icon"></i>
                <% else_if $Content %>
                    <span>$Content</span>
                <% else %>
                    <span>$Title</span>
                <% end_if %>
            </label>
            <% if $ShowTitle %><span>$Title</span><% end_if %>
    <% end_loop %>
</ul>
