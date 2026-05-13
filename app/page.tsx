import Navbar from "@/components/navbar";
import { Button } from "@/components/ui/button"
import Image from "next/image";
import Link from "next/link";

export default function Home() {
  return (
    <div className="flex min-h-screen flex-col bg-taupe-50">
      <main className="flex-1">

        <section className="container mx-auto px-4 py-32">
          <div className="mx-auto max-w-4xl text-center font-[Newsreader]">
            <h1 className="text-black mb-6 text-5xl font-bold">
              DAILY COFFEE
            </h1>
            <p className="text-muted-background mb-10 text-xl">
              "Your Daily Dose of Delight"
            </p>
            <div className="flex flex-col items-center gap-4">
              <Link href="/menu">
                <Button size="lg" className="bg-olive-700 h-10 w-35 font-medium">
                  Browse our Menu
                </Button>
              </Link>
            </div>
          </div>
        </section>
      </main>
    </div>
  );
}
