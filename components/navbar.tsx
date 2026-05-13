import Image from "next/image";
import Link from "next/link";
import { Button } from "./ui/button";

export default function Navbar() {
    return (
        <nav className="flex flex-row border-b h-15 border-gray-200 bg-taupe-50">
            <div className="container mx-auto my-auto flex h-10 items-center px-3 justify-between">
                <Link href="/" className="flex items-center gap-2 font-[Source_Code_Pro] text-3xl font-semibold">
                    <Image src="/dc_logobg.png" alt="Daily Coffee Logo" width={35} height={35} />
                    DAILY COFFEE
                </Link>
                <div className="flex items-center gap-3 font-[Inter]">
                    <Link href="/menu">Menu</Link>
                    <Link href="/about-us">About Us</Link>
                    <Link href="/sign-in">
                        <Button>Log In</Button>
                    </Link>
                </div>
            </div>
        </nav>
    );
}


