  @php
      $settings_details = getGeneralSettingsDetails();
      $system_current_version = systemCurrentVersion();
  @endphp
  <footer class="footer">
      <div class="d-flex footer-wraper justify-content-between pr-2 w-100">
          <p class="mb-0">{!! xss_clean($settings_details['copyright_text']) !!}</p>
          <p class="mb-0">Version {{ $system_current_version }}</p>
      </div>
  </footer>
