"use client";

import { useState } from "react";


export default function SignIn() {
    const [email, setEmail] = useState("");
    const [password, setPassword] = useState("");
    const [remember, setRemember] = useState(false);

    const handleLogin = (e: React.MouseEvent<HTMLButtonElement>) => {
        e.preventDefault();

        // Logic HERE

    };

    return (

        <div
            className="h-screen overflow-hidden flex flex-col bg-no-repeat bg-cover bg-center"
            style={{ backgroundImage: "url('/bg1.jpg')" }}
        >
            <div className="flex-1 flex items-center justify-center">
                <div className="relative z-10 w-full max-w-md flex flex-col items-center">
                    <h1 className="font-[Newsreader] text-4xl font-bold tracking-widest text-black mb-7">
                        LOGIN
                    </h1>

                    <div className="w-full mb-4">
                        <label className="block text-md text-[#7a6050] mb-1">
                            Email
                        </label>
                        <input
                            type="email"
                            placeholder="dailydosecoffee@gmail.com"
                            value={email}
                            onChange={(e) => setEmail(e.target.value)}
                            className="w-full bg-transparent border-b border-[#c8b09a] py-1.5 px-0.5 text-md outline-none"
                        />
                    </div>

                    <div className="w-full mb-3">
                        <label className="block text-md text-[#7a6050] tracking-wide mb-1">
                            Password
                        </label>
                        <input
                            type="password"
                            placeholder="••••••"
                            value={password}
                            onChange={(e) => setPassword(e.target.value)}
                            className="w-full bg-transparent border-b border-[#c8b09a] py-1.5 px-0.5 text-md outline-none"
                        />
                    </div>

                    <div className="w-full flex items-center gap-2 my-2.5">
                        <input
                            id="remember"
                            type="checkbox"
                            checked={remember}
                            onChange={(e) => setRemember(e.target.checked)}
                            className="w-3.5 h-3.5 accent-[#8a6040] cursor-pointer"
                        />
                        <label htmlFor="remember" className="text-md text-[#7a6050] cursor-pointer select-none">
                            Remember Me
                        </label>
                    </div>

                    <button
                        onClick={handleLogin}
                        className="w-full bg-[#3a2a1a] text-[#fdf7f2] rounded py-3 text-md font-medium mt-3 mb-4 hover:bg-[#5a3e28]"
                    >
                        LOGIN
                    </button>

                    <p className="text-md text-[#9a8070] tracking-wide">
                        Not a member?{" "}
                        <a href="/sign-up" className="text-[#7a5030] hover:underline">
                            Sign up now
                        </a>
                    </p>
                </div>
            </div>
        </div>
    )
}