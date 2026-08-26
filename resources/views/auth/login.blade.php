<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login TaskHub</title>
    <link rel="icon" type="image/png" href="/favicon.png?v=4">
</head>
<body style="background-color: #F6F8FA; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Helvetica, Arial, sans-serif; margin: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 100vh;">

    {{-- Logo T --}}
    <div style="margin-bottom: 24px;">
        <div style="width: 48px; height: 48px; border-radius: 50%; background: linear-gradient(135deg,#FF6B4A,#FF8F73); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 20px;">
            T
        </div>
    </div>

    {{-- Box Login Style GitHub --}}
    <div style="width: 100%; max-width: 308px;">
        <h1 style="font-size: 24px; font-weight: 300; text-align: center; margin-bottom: 16px; color: #1F2328; margin-top: 0;">Login TaskHub</h1>

        <div style="background-color: #ffffff; border: 1px solid #D0D7DE; border-radius: 6px; padding: 16px;">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email atau Username --}}
                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-size: 14px; font-weight: 500; color: #1F2328; margin-bottom: 8px;">
                        Email/Username
                    </label>
                    <input type="text" name="name" required autofocus placeholder="Masukkan email atau username"
                        style="width: 100%; padding: 5px 12px; font-size: 14px; line-height: 20px; color: #1F2328; background-color: #ffffff; border: 1px solid #D0D7DE; border-radius: 6px; outline: none; box-sizing: border-box;">
                </div>

                {{-- Password --}}
                <div style="margin-bottom: 16px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                        <label style="font-size: 14px; font-weight: 500; color: #1F2328;">Password</label>
                        {{-- @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" style="font-size: 12px; color: #0969DA; text-decoration: none;">Lupa password?</a>
                        @endif --}}
                    </div>
                    <input type="password" name="password" required
                           style="width: 100%; padding: 5px 12px; font-size: 14px; line-height: 20px; color: #1F2328; background-color: #ffffff; border: 1px solid #D0D7DE; border-radius: 6px; outline: none; box-sizing: border-box;">
                </div>

                {{-- Tombol Sign in --}}
                <button type="submit"
                        style="width: 100%; padding: 5px 16px; font-size: 14px; font-weight: 500; line-height: 20px; color: #ffffff; background-color: #1F883D; border: 1px solid rgba(27,31,36,0.15); border-radius: 6px; cursor: pointer; text-align: center;">
                    Sign in
                </button>
            </form>
        </div>

        {{-- Footer Card --}}
        <div style="margin-top: 16px; border: 1px solid #D0D7DE; border-radius: 6px; padding: 16px; text-align: center; font-size: 14px; color: #1F2328; background-color: #ffffff;">
            Belum punya akun? <a href="{{ route('register') }}" style="color: #0969DA; text-decoration: none;">Daftar sekarang</a>
        </div>
    </div>

    <footer style="margin-top: 32px; font-size: 12px; color: #57606A;">
        © {{ date('Y') }} TaskHub
    </footer>

</body>
</html>
