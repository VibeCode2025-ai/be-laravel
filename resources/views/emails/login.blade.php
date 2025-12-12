<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Có người đăng nhập vào tài khoản Discord</title>
    </head>
    <body
        style="
            margin: 0;
            padding: 0;
            background: #f9f9f9;
            font-family: 'Helvetica Neue', Arial, sans-serif;
            color: #2d3748;
        "
    >
        <!-- PREHEADER -->
        <div
            style="
                display: none;
                font-size: 1px;
                color: #f9f9f9;
                line-height: 1px;
                max-height: 0px;
                opacity: 0;
                overflow: hidden;
            "
        >
            Có người đăng nhập vào tài khoản Discord của bạn từ {{ $city }}, {{
            $country }}.
        </div>

        <table
            width="100%"
            cellpadding="0"
            cellspacing="0"
            border="0"
            style="background: #f9f9f9; padding: 20px 0"
        >
            <tr>
                <td align="center">
                    <!-- MAIN CARD -->
                    <table
                        width="100%"
                        cellpadding="0"
                        cellspacing="0"
                        border="0"
                        style="
                            max-width: 600px;
                            margin: 0 auto;
                            background: #ffffff;
                            border-radius: 12px;
                            overflow: hidden;
                            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
                        "
                    >
                        <!-- LOGO HEADER -->
                        <tr>
                            <td
                                style="
                                    padding: 28px 30px 20px;
                                    text-align: center;
                                "
                            >
                                <img
                                    src="{{ asset('storage/img/account.png') }}"
                                    alt="Discord"
                                    width="40"
                                    style="display: block; margin: 0 auto"
                                />
                            </td>
                        </tr>

                        <!-- BODY -->
                        <tr>
                            <td
                                style="
                                    padding: 0 30px 32px;
                                    font-size: 15px;
                                    line-height: 1.7;
                                    color: #2d3748;
                                "
                            >
                                <h2
                                    style="
                                        margin: 0 0 16px;
                                        font-size: 20px;
                                        font-weight: bold;
                                        color: #1a202c;
                                        text-align: center;
                                    "
                                >
                                    Chào {{ $user->fullname }},
                                </h2>

                                <p style="margin: 0 0 20px; text-align: center">
                                    Có người đang muốn đăng nhập vào tài khoản
                                    Discord của bạn từ một
                                    <strong>địa điểm mới</strong>.<br />
                                    Nếu người đó là bạn, hãy nhấp vào đường dẫn
                                    phía dưới để cấp quyền đăng nhập.
                                </p>

                                <!-- INFO BOX -->
                                <table
                                    width="100%"
                                    cellpadding="12"
                                    cellspacing="0"
                                    border="0"
                                    style="
                                        background: #f8f9fa;
                                        border-radius: 8px;
                                        margin: 20px 0;
                                    "
                                >
                                    <tr>
                                        <td style="padding: 0">
                                            <strong>Địa Chỉ IP:</strong> {{ $ip
                                            }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 8px 0 0">
                                            <strong>Địa Điểm:</strong> {{ $city
                                            }}, Ho Chi Minh, Vietnam
                                        </td>
                                    </tr>
                                </table>

                                <p style="margin: 0 0 28px; text-align: center">
                                    Nếu <strong>đó không phải là bạn</strong>,
                                    hãy nhấp vào đây để
                                    <strong>cài lại mật khẩu</strong> và
                                    <strong
                                        >đăng xuất khỏi tất cả thiết bị</strong
                                    >.
                                </p>

                                <!-- CTA BUTTONS -->
                                <table
                                    width="100%"
                                    cellpadding="0"
                                    cellspacing="0"
                                    border="0"
                                >
                                    <tr>
                                        <td
                                            align="center"
                                            style="padding: 8px 0"
                                        >
                                            <a
                                                href="http://localhost:3000/confirm-login"
                                                style="
                                                    background: #5865f2;
                                                    color: #ffffff;
                                                    font-size: 15px;
                                                    font-weight: bold;
                                                    text-decoration: none;
                                                    padding: 12px 32px;
                                                    border-radius: 6px;
                                                    display: inline-block;
                                                "
                                            >
                                                Xác Minh Đăng Nhập
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            align="center"
                                            style="padding: 8px 0"
                                        >
                                            <a
                                                href="http://localhost:3000/reset-and-logout"
                                                style="
                                                    color: #5865f2;
                                                    font-size: 14px;
                                                    text-decoration: underline;
                                                "
                                            >
                                                Cài lại mật khẩu & đăng xuất tất
                                                cả
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>
