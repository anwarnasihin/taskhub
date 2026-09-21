<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Lupa Password - TaskHub</title>

    <link rel="icon" type="image/png" href="/favicon.png?v=4">
</head>

<body style="
    background-color: #F6F8FA;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Helvetica, Arial, sans-serif;
    margin: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
">

    <div style="width: 100%; max-width: 340px;">

        {{-- Logo --}}
        <div style="
            display: flex;
            justify-content: center;
            margin-bottom: 24px;
        ">
            <div style="
                width: 48px;
                height: 48px;
                border-radius: 50%;
                background: linear-gradient(135deg,#FF6B4A,#FF8F73);
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-weight: bold;
                font-size: 20px;
            ">
                T
            </div>
        </div>

        {{-- Title --}}
        <h1 style="
            font-size: 24px;
            font-weight: 300;
            text-align: center;
            color: #1F2328;
            margin: 0 0 8px;
        ">
            Lupa Password?
        </h1>

        <p style="
            font-size: 13px;
            line-height: 20px;
            text-align: center;
            color: #57606A;
            margin: 0 0 16px;
        ">
            Masukkan email akun TaskHub kamu.
            Kami akan mengirimkan link untuk membuat password baru.
        </p>

        {{-- Status --}}
        @if (session('status'))
            <div style="
                background-color: #E6FFED;
                border: 1px solid #A7F3D0;
                color: #166534;
                border-radius: 6px;
                padding: 10px 12px;
                margin-bottom: 12px;
                font-size: 13px;
            ">
                {{ session('status') }}
            </div>
        @endif

        {{-- Error --}}
        @if ($errors->any())
            <div style="
                background-color: #FFF0F0;
                border: 1px solid #FFCDD2;
                color: #CF222E;
                border-radius: 6px;
                padding: 10px 12px;
                margin-bottom: 12px;
                font-size: 13px;
            ">
                {{ $errors->first() }}
            </div>
        @endif

        {{-- Form --}}
        <div style="
            background-color: #ffffff;
            border: 1px solid #D0D7DE;
            border-radius: 6px;
            padding: 16px;
        ">

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <label style="
                    display: block;
                    font-size: 14px;
                    font-weight: 500;
                    color: #1F2328;
                    margin-bottom: 8px;
                ">
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="email"
                    placeholder="contoh@email.com"
                    style="
                        width: 100%;
                        padding: 7px 12px;
                        font-size: 14px;
                        line-height: 20px;
                        color: #1F2328;
                        background-color: #ffffff;
                        border: 1px solid #D0D7DE;
                        border-radius: 6px;
                        outline: none;
                        box-sizing: border-box;
                    "
                >

                <button
                    type="submit"
                    style="
                        width: 100%;
                        margin-top: 16px;
                        padding: 7px 16px;
                        font-size: 14px;
                        font-weight: 500;
                        line-height: 20px;
                        color: #ffffff;
                        background-color: #0969DA;
                        border: 1px solid rgba(27,31,36,0.15);
                        border-radius: 6px;
                        cursor: pointer;
                    "
                >
                    Kirim Link Reset Password
                </button>

            </form>

        </div>

        {{-- Back to Login --}}
        <div style="
            margin-top: 16px;
            text-align: center;
            font-size: 13px;
        ">

            <a
                href="{{ route('login') }}"
                style="
                    color: #0969DA;
                    text-decoration: none;
                "
            >
                ← Kembali ke Login
            </a>

        </div>

    </div>

</body>
</html>
