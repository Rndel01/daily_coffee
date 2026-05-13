"use client";

import { useState } from "react";

export default function SignUp() {
    const [name, setName] = useState("");
    const [contact, setContact] = useState("");
    const [email, setEmail] = useState("");
    const [password, setPassword] = useState("");
    const [confirmPassword, setConfirmPassword] = useState("");

    const handleSignUp = (e: React.MouseEvent<HTMLButtonElement>) => {
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
                    <h1 className="text-4xl font-bold tracking-widest text-black mb-7">
                        SIGN UP
                    </h1>

                    <div className="w-full mb-4">
                        <label className="block text-md text-[#7a6050] mb-1">
                            Name/Username
                        </label>
                        <input
                            type="text"
                            placeholder="Daily Coffee"
                            value={name}
                            onChange={(e) => setName(e.target.value)}
                            className="w-full bg-transparent border-b border-[#c8b09a] py-1.5 px-0.5 text-md outline-none"
                        />
                    </div>

                    <div className="w-full mb-4">
                        <label className="block text-md text-[#7a6050] mb-1">
                            Contact Number
                        </label>
                        <input
                            type="tel"
                            placeholder="096971287654"
                            value={contact}
                            onChange={(e) => setContact(e.target.value)}
                            className="w-full bg-transparent border-b border-[#c8b09a] py-1.5 px-0.5 text-md outline-none"
                        />
                    </div>

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

                    <div className="w-full mb-4">
                        <label className="block text-md text-[#7a6050] mb-1">
                            Password
                        </label>
                        <input
                            type="password"
                            placeholder="•••••"
                            value={password}
                            onChange={(e) => setPassword(e.target.value)}
                            className="w-full bg-transparent border-b border-[#c8b09a] py-1.5 px-0.5 text-md outline-none"
                        />
                    </div>

                    <div className="w-full mb-6">
                        <label className="block text-md text-[#7a6050] mb-1">
                            Confirm Password
                        </label>
                        <input
                            type="password"
                            placeholder="•••••"
                            value={confirmPassword}
                            onChange={(e) => setConfirmPassword(e.target.value)}
                            className="w-full bg-transparent border-b border-[#c8b09a] py-1.5 px-0.5 text-md outline-none"
                        />
                    </div>

                    <button
                        onClick={handleSignUp}
                        className="w-full bg-[#3a2a1a] text-[#fdf7f2] rounded py-3 text-md font-medium tracking-widest hover:bg-[#5a3e28]  "
                    >
                        SIGN UP
                    </button>

                    <p className="text-md text-[#9a8070] tracking-wide mt-4">
                        Already a member?{" "}
                        <a href="/sign-in" className="text-[#7a5030] hover:underline">
                            Log in
                        </a>
                    </p>
                </div>
            </div>
        </div>
    );
}