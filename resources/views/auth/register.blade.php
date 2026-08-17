<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar — TaskHub</title>
</head>
<body style="background-color: #F6F8FA; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Helvetica, Arial, sans-serif; margin: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 100vh;">

    {{-- Logo T --}}
    <div style="margin-bottom: 24px;">
        <div style="width: 48px; height: 48px; border-radius: 50%; background: linear-gradient(135deg,#FF6B4A,#FF8F73); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 20px;">
            T
        </div>
    </div>

    {{-- Box Register Style GitHub --}}
    <div style="width: 100%; max-width: 308px;">
        <h1 style="font-size: 24px; font-weight: 300; text-align: center; margin-bottom: 16px; color: #1F2328; margin-top: 0;">Buat Akun TaskHub</h1>

        <div style="background-color: #ffffff; border: 1px solid #D0D7DE; border-radius: 6px; padding: 16px;">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Username --}}
                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-size: 14px; font-weight: 500; color: #1F2328; margin-bottom: 8px;">Username</label>
                    <input type="text" name="name" required autofocus placeholder="contoh: anwar" value="{{ old('name') }}"
                        style="width: 100%; padding: 5px 12px; font-size: 14px; line-height: 20px; color: #1F2328; background-color: #ffffff; border: 1px solid #D0D7DE; border-radius: 6px; outline: none; box-sizing: border-box;">
                </div>

                {{-- Email --}}
                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-size: 14px; font-weight: 500; color: #1F2328; margin-bottom: 8px;">Email</label>
                    <input type="email" name="email" required value="{{ old('email') }}"
                           style="width: 100%; padding: 5px 12px; font-size: 14px; line-height: 20px; color: #1F2328; background-color: #ffffff; border: 1px solid #D0D7DE; border-radius: 6px; outline: none; box-sizing: border-box;">
                </div>

                {{-- Password --}}
                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-size: 14px; font-weight: 500; color: #1F2328; margin-bottom: 8px;">Password</label>
                    <input type="password" name="password" required
                           style="width: 100%; padding: 5px 12px; font-size: 14px; line-height: 20px; color: #1F2328; background-color: #ffffff; border: 1px solid #D0D7DE; border-radius: 6px; outline: none; box-sizing: border-box;">
                </div>

                {{-- Confirm Password --}}
                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-size: 14px; font-weight: 500; color: #1F2328; margin-bottom: 8px;">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required
                           style="width: 100%; padding: 5px 12px; font-size: 14px; line-height: 20px; color: #1F2328; background-color: #ffffff; border: 1px solid #D0D7DE; border-radius: 6px; outline: none; box-sizing: border-box;">
                </div>

                {{-- Tombol Register --}}
                <button type="submit"
                        style="width: 100%; padding: 5px 16px; font-size: 14px; font-weight: 500; line-height: 20px; color: #ffffff; background-color: #1F883D; border: 1px solid rgba(27,31,36,0.15); border-radius: 6px; cursor: pointer; text-align: center;">
                    Daftar
                </button>
            </form>
        </div>

        {{-- Footer Card --}}
        <div style="margin-top: 16px; border: 1px solid #D0D7DE; border-radius: 6px; padding: 16px; text-align: center; font-size: 14px; color: #1F2328; background-color: #ffffff;">
            Sudah punya akun? <a href="{{ route('login') }}" style="color: #0969DA; text-decoration: none;">Masuk di sini</a>
        </div>
    </div>

    <footer style="margin-top: 32px; font-size: 12px; color: #57606A;">
        © {{ date('Y') }} TaskHub
    </footer>

</body>
</html>
