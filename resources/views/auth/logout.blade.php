<x-app-layout :title="__('Logout')" :ogp-tags="false">
  <div class="content-box">
    <form action="{{ route('logout') }}" method="POST">
      @csrf
      <p class="text-18px">本当にログアウトしますか？</p>
      <button type="submit" class="btn btn-danger">{{ __('Logout') }}</button>
    </form>
  </div>
</x-app-layout>
